<?

    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\ModuleManager;
    use Bitrix\Main\EventManager;

    Loc::loadMessages(__FILE__);

    class net22sky_weirdjob extends CModule
    {
        var $MODULE_ID = "net22sky.weirdjob";
        var $MODULE_VERSION;
        var $MODULE_VERSION_DATE;
        var $MODULE_NAME;
        var $MODULE_DESCRIPTION;


        function __construct()
        {
            //	Получаем версию и дату из файла version.php
            $arModuleVersion = array();
            $path = str_replace("\\", "/", __FILE__);
            $path = substr($path, 0, strlen($path) - strlen("/index.php"));

            include($path . "/version.php");

            if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
                $this->MODULE_VERSION = $arModuleVersion["VERSION"];
                $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            }

            $this->MODULE_NAME = Loc::getMessage('WEIRD_JOB_MODULE_NAME');
            $this->MODULE_DESCRIPTION = Loc::getMessage('WEIRD_JOB_MODULE_DESCRIPTION');
            $this->PARTNER_NAME = Loc::getMessage('WEIRD_JOB_PARTNER_NAME');
            $this->PARTNER_URI = "";
        }

        public function isVersionD7()
        {
            return CheckVersion(ModuleManager::getVersion('main'), '14.00.00');
        }

        /*
         * 	Устанавливаем все, что связано с БД
         * */
        function InstallDB()
        {
        return true;
        }

        /*
         * 	Удаляем все, что связано с БД
         * */
        function UnInstallDB()
        {
         return true;
        }

        /*
         * 	Устанавливаем события
         * */
        function InstallEvents()
        {
            return true;
        }

        /*
         * 	Удаляем события
         * */
        function UnInstallEvents()
        {
            return true;
        }

        /*
         * 	Устанавливаем файлы
         * */
        function InstallFiles()
        {
            return true;
        }

        /*
         * 	Удалаяем файлы
         * */
        function UnInstallFiles()
        {
            return true;
        }

        function DoInstall()
        {
            global $APPLICATION;

            if ($this->isVersionD7()) {
                // Регистрируем модуль
                ModuleManager::registerModule($this->MODULE_ID);
                $this->InstallDB();
                $this->InstallEvents();
                $this->InstallFiles();

                EventManager::getInstance()->registerEventHandler(
                    "iblock",
                    "OnIBlockPropertyBuildList",
                    $this->MODULE_ID,
                    "Net22sky\\Weirdjob\\PropertyCustom",
                    "GetUserTypeDescription"
                );

            } else {
                $APPLICATION->ThrowException(Loc::getMessage("WEIRD_JOB_INSTALL_ERROR_VERSION"));
            }
            return true;
        }

        function DoUninstall()
        {
            $this->UnInstallFiles();
            $this->UnInstallEvents();
            $this->UnInstallDB();
            UnRegisterModuleDependences("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "PropertyCustom", "GetUserTypeDescription");
            ModuleManager::unRegisterModule($this->MODULE_ID);
            return true;
        }



    }
?>