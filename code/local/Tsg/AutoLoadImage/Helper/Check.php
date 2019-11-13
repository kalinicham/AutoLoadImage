<?php

class Tsg_AutoLoadImage_Helper_Check
{
    protected $catalog = 'tmp';
    protected $filedName = array('sku','link');

    /**
     * @param array $headFile
     * @return string
     */
    public function checkField(array $headFile): string
    {
        $nonExist = '';
        foreach ($this->filedName as $value) {
            if (!in_array($value,$headFile)) {
                if ($nonExist !== '') {
                    $nonExist = $nonExist.', ';
                }
                $nonExist = $nonExist . $value;
            }
        }

        return $nonExist;
    }

    /**
     * @param string $link
     * @return bool
     */
    public function checkLink(string $link): bool
    {
        $pattern = "/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(\/.*(png|jpeg|jpg))$/i";
        $result = preg_match($pattern, $link);
        return $result;
    }

    /**
     * @return bool
     */
    public function checkDir(): bool
    {
        $importCatalog = Mage::getBaseDir('media') . DS . $this->catalog . DS ;

        if (!file_exists($importCatalog)) {
            try {
                $io = new Varien_Io_File();
                $io->mkdir($importCatalog);
            } catch (Exception $e) {
                Mage::log($e, null, 'tsg_import_image.log');
                return false;
            }
        }

        return true;
    }





}
