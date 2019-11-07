<?php

class Tsg_AutoLoadImage_Helper_Check
{
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

    public function checkSku(string $sku): bool
    {
        $product = Mage::getModel('catalog/product');
        $result = $product->getIdBySku($sku);
        return $result;
    }

    public function checkLink(string $link): bool
    {
        $result = preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $link);
        return $result;
    }

    public function checkDir()
    {
        $importCatalog = Mage::getBaseDir('media') . DS . $this->catalog . DS ;

        if (!file_exists($importCatalog)) {
            try {
                $io = new Varien_Io_File();
                $io->mkdir($importCatalog);
            } catch (Exception $e) {

                return false;
            }
        }

        return true;
    }
}
