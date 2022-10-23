<?

    namespace Net22sky\Weirdjob;


    use Net22sky\Weirdjob\Utils;


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


        // Функция вывода свойства в панели
        public static function GetPropertyFieldHtml($arProperty, $arValue, $strHTMLControlName): string
        {
            // Описание превращаем обратно в массив ( в шаблоне также )
            $arValue["DESCRIPTION"] = unserialize($arValue["DESCRIPTION"]);
            $html = '<select id="selectInfoblock" name="' . $strHTMLControlName["DESCRIPTION"] . '">';
            $html .= '<option value="">(выберите инфоблок)</option>';

            foreach (Utils::getIblockList() as $key => $val) {
                $html .= '<option value="' . $key . '"';
                if ($key == $arValue["DESCRIPTION"]) {
                    $html .= 'selected="selected"';
                }
                $html .= '>' . $val . '</option>';
            }
            $html .= '</select>';

            /* Что будет выведено:
               * Первый селект формируем программно второй зависит от выбора первого - надо вешать js на свойство "onchange" не реализован
               * Вместо второго стоит оконный выбор для демонстрации
            */
            return '
      <table border="0" cellspacing="0" cellpadding="0" width="100%" class="internal">
        <tbody>
          <tr class="heading">
            <td>Инфоблок</td>
            <td>Раздел</td>
          </tr>
          <tr> 
           
            <td align="center">
            ' . $html . '
        </td>
             <td align="center" width="50%">
             <script>
             let select = document.getElementById("selectInfoblock");
        select.addEventListener("change", function () {
            console.log("выбран id=" + select.value)
            /*
            По событию первого селекта получим разделы и сформируем второй селект
            */
            BX.ajax.runAction("net22sky:weirdjob.api.reviews.get",
                {
                    data: {
                        id:' . $arValue["DESCRIPTION"] . ',
                        tp:"12"
                    },
                }
                ).then(function (response) {
                    console.log(response);
                }, function (response) {
            });
        });
       

    </script>
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