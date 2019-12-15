<?

namespace app\models;

use Yii;
use yii\helpers\Url;


class Upload extends yii\base\Model
{
    /**
     * Returns link to uploaded file
     *
     * @param string $path
     * @param string $id
     * @param string $fileName
     * @return bool|string
     */
    public static function fileLink(string $path, string $id, string $fileName)
    {
        $storageUrl = Url::to('@storage/') . "{$path}/{$id}/{$fileName}";
        if (file_exists($storageUrl)) {
            return Url::to("/{$path}/{$id}/{$fileName}");
        }

        return false;
    }
}