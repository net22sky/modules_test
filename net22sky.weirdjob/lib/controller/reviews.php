<?php

    namespace Net22sky\Weirdjob\Controller;

    use \Bitrix\Main\Error;
    use \Bitrix\Main\Engine\Controller;
    use \Bitrix\Main\Data\Cache;

    /**
     * TODO: Необхадимо добавить обработку ошибок
     */
    class Reviews extends Controller
    {

        /**
         * Заготовка для формирования списка разделов в зависимости от выбора инфоблока
         * TODO: необходимо кеширование результатов
         */
        public function listAction()
        {
            $request = $this->getRequest();
            return ['list' => [
                'fields' => $request,
                '‘properties’' => [
                    'city' => "",
                    'rating' => "",
                ],
            ],
            ];
        }

        /**
         * Основная функция для получения списка отзывов
         */
        public function getAction()
        {
            $request = $this->getRequest();
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