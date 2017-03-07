<?php

namespace Slackbot;

use Slackbot\tests\PhpunitHelper;

/** @noinspection PhpUndefinedClassInspection */
class WhiteListTest extends \PHPUnit_Framework_TestCase
{
    private function getWhiteList()
    {
        return (new PhpunitHelper())->getWhiteList();
    }

    public function testGetRequest()
    {
        $whitelist = $this->getWhiteList();

        $this->assertEquals((new PhpunitHelper())->getRequest(), $whitelist->getRequest());

        // overwrite the request
        $whitelist->setRequest([]);

        $this->assertEmpty($whitelist->getRequest());
    }

    public function testIsUsernameWhiteListed()
    {
        $whitelist = $this->getWhiteList();

        $inputsOutputs = [
            [
                'input' => [
                    'access-control' => [
                        'whitelist' => [
                            'userId' => [],
                        ],
                    ],
                ],
                'output' => null,
            ],
            [
                'input' => [
                    'access-control' => [
                        'whitelist' => [
                            'userId' => [],
                        ],
                    ],
                ],
                'output' => null
            ],
            [
                'input' => (new PhpunitHelper())->getDictionaryData('whitelist'),
                'output' => true
            ],
            [
                'input' => [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [
                                'blahblah',
                            ],
                            'userId' => [
                                'blahblah',
                            ],
                        ],
                    ],
                ],
                'output' => false
            ],
            [
                'input' => [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [
                                'blahblah',
                            ],
                            'userId' => [
                                'blahblah',
                            ],
                        ],
                    ],
                ],
                'output' => false
            ]
        ];

        $dictionary = new Dictionary();
        foreach ($inputsOutputs as $inputOutput) {
            $dictionary->setData($inputOutput['input']);

            // set the dictionary
            $whitelist->setDictionary($dictionary);

            $this->assertEquals($inputOutput['output'], $whitelist->isUsernameWhiteListed());
        }
    }

    public function testIsUserIdWhiteListed()
    {
        $inputsOutputs = [
            [
                'input' => [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [],
                        ],
                    ],
                ],
                'output' => null,
            ],
            [
                'input'=> [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [],
                            'userId'   => [
                                'dummyUserId',
                            ],
                        ],
                    ],
                ],
                'output' => true
            ],
            [
                'input'=> [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [],
                            'userId'   => [
                                'dummyUserId',
                            ],
                        ],
                    ],
                ],
                'output' => true
            ],
            [
                'input'=> [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [],
                            'userId'   => [],
                        ],
                    ],
                ],
                'output' => false
            ],
            [
                'input'=> [
                    'access-control' => [
                        'whitelist' => [
                            'username' => [],
                            'userId'   => [
                                'blahblah',
                            ],
                        ],
                    ],
                ],
                'output' => false
            ]
        ];

        $whitelist = $this->getWhiteList();
        $dictionary = new Dictionary();
        foreach ($inputsOutputs as $inputOutput) {
            $dictionary->setData($inputOutput['input']);

            // set the dictionary
            $whitelist->setDictionary($dictionary);

            $this->assertEquals($inputOutput['output'], $whitelist->isUserIdWhiteListed());
        }
    }
}
