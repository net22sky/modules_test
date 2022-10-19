<?

    namespace Net22sky\Weirdjob;

    use Bitrix\Main\Loader;
    use Bitrix\Iblock\IblockTable;

    Loader::includeModule('iblock');

    class PropertyCustom
    {
        // Информация о данном свойстве
        const USER_TYPE = 'cityProp';

        public static function GetUserTypeDescription(): array
        {
            return array(
                "PROPERTY_TYPE" => "S",
                "USER_TYPE" => self::USER_TYPE,
                "DESCRIPTION" => " City",
                "GetPropertyFieldHtml" => array(__CLASS__, "GetPropertyFieldHtml"),
                "ConvertToDB" => array(__CLASS__, "ConvertToDB"),
                "ConvertFromDB" => array(__CLASS__, "ConvertFromDB"),
            );
        }

        public static function getIblockList(): array{

            $arrIblock = array();
            $iblockResult = IblockTable::getList();
            foreach ($iblockResult as $value) {
                $arrIblock[$value['ID']] = $value['NAME'];
            }
            return $arrIblock;
        }

        // Функция вывода свойства в панели
        public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName): string
        {
            // Описание превращаем обратно в массив ( в шаблоне также )
            $arValue["DESCRIPTION"] = unserialize($arValue["DESCRIPTION"]);
            $html = '<select name="' . $strHTMLControlName["DESCRIPTION"] . '">';
            $html .= '<option value="">(выберите инфоблок)</option>';

            foreach (self::getIblockList() as $key => $val) {
                $html .= '<option value="' . $key . '"';
                if ($key == $arValue["DESCRIPTION"]) {
                    $html .= 'selected="selected"';
                }
                $html .= '>' . $val . '</option>';
            }
            $html .= '</select>';

            // Что будет выведено:
            return '
      <table border="0" cellspacing="0" cellpadding="0" width="100%" class="internal">
        <tbody>
          <tr class="heading">
            <td>Элемент</td>
            <td>Вкладка</td>
          </tr>
          <tr> 
           
            <td align="center">
            ' . $html . '
        </td>
             <td align="center" width="50%">
              <input name="' . $strHTMLControlName["VALUE"] . '" id="' . $strHTMLControlName["VALUE"] . '" value="' . htmlspecialcharsex($arValue["VALUE"]) . '" size="5" type="text">
              <input type="button" value="Выбрать" onClick="jsUtils.OpenWindow(\'/bitrix/admin/iblock_section_search.php?lang=' . LANG . '&IBLOCK_ID=' . $arValue["DESCRIPTION"] . '&n=' . $strHTMLControlName["VALUE"] . '\', 600, 500);">
              <br><span id="sp_' . md5($strHTMLControlName["VALUE"]) . '_' . $key . '" >' . $arItem["NAME"] . '</span>
            </td>
          </tr>
        </tbody>
      </table>
    ';
        }

        // При сохранении свойства в БД
        public static function ConvertToDB($arProperty, $arValue)
        {
            if (is_array($arValue) && array_key_exists("VALUE", $arValue) && !empty($arValue['VALUE'])) {
                $arValue["VALUE"] = serialize($arValue["VALUE"]);
                $arValue['DESCRIPTION'] = serialize($arValue["DESCRIPTION"]);
            }

            return $arValue;
        }

        public function ConvertFromDB($arProperty, $arValue)
        {
            if (is_array($arValue) && array_key_exists("VALUE", $arValue) && !empty($arValue['VALUE'])) {
                $arValue["VALUE"] = unserialize($arValue["VALUE"]);
                $arValue['DESCRIPTION'] = unserialize($arValue["DESCRIPTION"]);
            }
            return $arValue;
        }
    }
?>