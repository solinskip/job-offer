<?

/**
 * RelationTrait
 *
 * @author Yohanes Candrajaya <moo.tensai@gmail.com>
 * @since 1.0
 */

namespace app\models\traits;

use Yii;
use \yii\db\Exception;
use yii\helpers\ArrayHelper;
use \yii\helpers\StringHelper;

trait RelationTrait
{
    /**
     * Load all attributes including related attribute
     * @param $post
     * @param array $relations
     * @return bool
     */
    public function loadAll($post, $relations = [])
    {
        if ($this->load($post)) {
            foreach ($relations as $relation) {
                $modelName = StringHelper::basename($this->getRelation($relation)->modelClass);
                $data = [];
                if (isset($post[$modelName])) {
                    $data = $post[$modelName];
                }
                $this->loadToRelation($relation, $data);
            }
            return true;
        }
        return false;
    }

    /**
     * @param $relName
     * @param $v
     * @return bool
     */
    private function loadToRelation($relName, $v)
    {
        /* @var yii\db\ActiveRecord $relModelClass */
        $relModelClass = $this->getRelation($relName)->modelClass;
        $childPKAttr = $relModelClass::primaryKey();
        $container = [];

        /** serve has many relation */
        if (ArrayHelper::isIndexed($v)) {
            foreach ($v as $childAttrs) {
                if (array_filter($childAttrs)) {
                    /* @var $relObj yii\db\ActiveRecord */
                    $relObj = (empty($childAttrs[$childPKAttr[0]])) ? new $relModelClass() : $relModelClass::findOne($childAttrs[$childPKAttr[0]]);

                    if (is_null($relObj)) {
                        $relObj = new $relModelClass();
                    }
                    if (in_array($this->scenario, array_keys($relObj->scenarios()))) {
                        $relObj->scenario = $this->scenario;
                    }
                    $relObj->load($childAttrs, '');
                    $container[] = $relObj;
                }
            }
        } else {
            /** serve has one relation */
            if (array_filter($v)) {
                /* @var $relObj yii\db\ActiveRecord */
                $relObj = (empty($v[$childPKAttr[0]])) ? new $relModelClass() : $relModelClass::findOne($v[$childPKAttr[0]]);

                if (is_null($relObj)) {
                    $relObj = new $relModelClass();
                }
                if (in_array($this->scenario, array_keys($relObj->scenarios()))) {
                    $relObj->scenario = $this->scenario;
                }
                $relObj->load($v, '');
                $container = $relObj;
            }
        }
        $this->populateRelation($relName, $container);

        return true;
    }

    /**
     * Save model (transactional) including all related model already loaded
     *
     * @param $relations
     * @return bool
     * @throws Exception
     */
    public function saveAllInTransaction($relations)
    {
        /* @var $this yii\db\ActiveRecord */
        $db = $this->getDb();
        $transaction = $db->beginTransaction();
        try {
            if ($this->saveAll($relations)) {
                $transaction->commit();
                return true;
            }

            $transaction->rollback();
            return false;
        } catch (Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
    }

    public function saveAll($relations)
    {
        $isNewRecord = $this->isNewRecord;
        try {
            if ($this->save()) {
                $error = false;
                if (!empty($this->relatedRecords)) {
                    // $relatedRecords @array of models from relations
                    foreach ($this->relatedRecords as $name => $records) {
                        if (!in_array($name, $relations)){
                            continue;
                        }
                        $AQ = $this->getRelation($name);
                        $link = $AQ->link;
                        $childKeyAttr = key($link);
                        $parentKeyAttr = $link[$childKeyAttr];
                        if (is_array($records)) { //serve has many relation
                            if (!empty($records)) {
                                $extantChildPKs = [];
                                $childPKAttr = $records[0]->primaryKey()[0];

                                foreach ($records as $index => $relModel) {
                                    $relModel->$childKeyAttr = $this->$parentKeyAttr;
                                    if (!empty($relModel->primaryKey)) {
                                        $extantChildPKs[] = $relModel->primaryKey;
                                    }
                                }

                                if (!$isNewRecord && is_int($this[$parentKeyAttr])) {
                                    $condition = [$childKeyAttr => $this[$parentKeyAttr]];
                                    if (!empty($extantChildPKs)) {
                                        $condition = ['and', $condition, ['not in', $childPKAttr, $extantChildPKs]];
                                    }
                                    ($AQ->modelClass)::deleteAll($condition);
                                }

                                foreach ($records as $index => $relModel) {
                                    $relSave = $relModel->save();
                                    if (!$relSave || !empty($relModel->errors)) {
                                        $modelName = Yii::t('appvar', StringHelper::basename($AQ->modelClass));
                                        $index++;
                                        foreach ($relModel->errors as $errorKey => $validation) {
                                            foreach ($validation as $errorMsg) {
                                                $this->addError($name . "_" . $index . "_" . $errorKey, "$modelName #$index: $errorMsg");
                                            }
                                        }
                                        $error = true;
                                    }
                                }
                            }
                        } else { //serve has one relation
                            if ($isNewRecord) {
                                $records->$childKeyAttr = $this->$parentKeyAttr;
                            }
                            $relSave = $records->save();

                            if (!$relSave || !empty($records->errors)) {
                                $modelName = Yii::t('appvar', StringHelper::basename($AQ->modelClass));
                                foreach ($records->errors as $errorKey => $validation) {
                                    foreach ($validation as $errorMsg) {
                                        $this->addError($name . "_" . $errorKey, "$modelName: $errorMsg");
                                    }
                                }
                                $error = true;
                            }
                        }
                    }
                }
                // Search relations that (children) haven't been populated in form
                $relatedRecords = $this->relatedRecords;
                $noChildren = [];
                foreach ($relations as $relation) {
                    if (empty($relatedRecords[$relation])) {
                        $noChildren[] = $relation;
                    }
                }
                // Deletion of children not related to parent (not populated in form)
                foreach ($noChildren as $relName) {
                    $AQ = $this->getRelation($relName);
                    $link = $AQ->link;
                    $childKeyAttr = key($link);
                    $parentKeyAttr = $link[$childKeyAttr];
                    $parentKeyValue = $this[$parentKeyAttr];
                    ($AQ->modelClass)::deleteAll([$childKeyAttr => $parentKeyValue]);
                }

                if ($error) {
                    $this->isNewRecord = $isNewRecord;
                    return false;
                }
                return true;
            } else {
                $this->isNewRecord = $isNewRecord;
                return false;
            }
        } catch (Exception $exc) {
            $this->isNewRecord = $isNewRecord;
            throw $exc;
        }
    }
}
