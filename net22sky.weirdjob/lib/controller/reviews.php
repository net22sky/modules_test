<?php

    namespace Net22sky\Weirdjob\Controller;

    use Net22sky\Weirdjob\Utils;
    use \Bitrix\Main\Error;
    use \Bitrix\Main\Engine\Controller;
    use \Bitrix\Main\Data\Cache;

    /**
     *  Для постраничной навигации
     */
    use \Bitrix\Main\Engine\Response;
    use \Bitrix\Main\UI\PageNavigation;


    /**
     * TODO: Необхадимо добавить обработку ошибок
     */
    class Reviews extends Controller
    {


        public  function configureActions()
        {
            return [
              'send' => [] // только для авторизованных..  либо через prefilters  new ActionFilter\Authentication()
            ];

        }

        /**
         * Заготовка для формирования списка разделов в зависимости от выбора инфоблока
         * TODO: необходимо кеширование результатов
         */
        public function listAction()
        {
            $request = $this->getRequest();
            return ['list' => [],];
        }

        /**
         * Основная функция для получения списка отзывов
         */
        public function getAction()
        {
            $request = $this->getRequest();

            // получим список элементов
            // $arrIblockItems = Utils::getIblockItems();
            //  преобразуем полученный массив в ответ
            // для постраничного вывода требуется использовать \Bitrix\Main\UI\PageNavigation
            // а также  класс возврашаюший результаты в форме объекта для работы с лимитами и смешениями
            //


            return ['list' => [
                'fields' => $request,
                '‘properties’' => [
                    'city' => "",
                    'rating' => "",
                ],
            ],
            ];
        }


    }