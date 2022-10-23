<?php
    namespace Net22sky\Weirdjob;

    use Bitrix\Iblock\IblockTable;
    use Bitrix\Main\Loader;

    Loader::includeModule('iblock');

    /**
     * Класс с дополнительными функциями
     */

    class Utils {

        /**
         * Получаем и обрабатываем список инфоблоков
         * TODO: Необхадимо добавить обработку ошибок
         * TODO: необходимо кеширование результатов
         */
        public static function getIblockList(): array{

            $arrIblock = array();
            $iblockResult = IblockTable::getList(
                array('select' => array('ID', 'NAME'))
            );
            foreach ($iblockResult as $value) {
                $arrIblock[$value['ID']] = $value['NAME'];
            }
            return $arrIblock;
        }

        public function getIblockItems():array{
            return [];
        }
    }