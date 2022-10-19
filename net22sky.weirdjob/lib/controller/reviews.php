<?php

    namespace Net22sky\Weirdjob\Controller;

    use \Bitrix\Main\Error;
    use \Bitrix\Main\Engine\Controller;


    class Reviews extends Controller
    {
        public function getAction()
        {
            $request = $this->getRequest();

            return ['list' => [
                        'fields' => '',
                        '‘properties’' => [
                            'city' => "",
                            'rating' => "",
                        ]
                    ]
                ];
        }

        private static function getList(){

        }

    }