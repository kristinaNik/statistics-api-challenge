<?php

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $docs['components']['schemas']['Statistics'] = [
            'type' => 'object',
            'properties' => [
                'review-count' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'average-score' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'date-group' => [
                    'type' => 'string',
                    'readOnly' => true,
                    'daily' => [
                        'review_count' => [
                            'type' => 'string',
                        ],
                        'average_score' => [
                            'type' => 'string'
                        ],
                        'day' => [
                            'type' => 'string'
                        ]
                    ],
                    'weekly' => [
                        'review_count' => [
                            'type' => 'string'
                        ],
                        'average_score' => [
                            'type' => 'string'
                        ],
                        'week' => [
                            'type' => 'string'
                        ]
                    ],
                    'monthly' => [
                        'review_count' => [
                            'type' => 'string'
                        ],
                        'average_score' => [
                            'type' => 'string'
                        ],
                        'month' => [
                            'type' => 'string'
                        ]
                    ]
                ],
                'createdAt' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'updatedAt' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'readOnly' => true,
            ],
        ];
        $customDefinition = [
            'in' => 'query',
            'name' => 'hotelId',
            'description' => 'Numeric ID of the hotel',
            'default' => 'hotelId'
        ];

        $documentation = [
            'paths' => [
                '/api/statistics/hotel/{hotelId}/overtime' => [
                    'get' => [
                        'tags' => ['Statistics'],
                        'summary' => 'Get the statistics of the hotel reviews.',
                        'parameters' =>  $customDefinition,
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Statistics collection response',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/Statistics',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $documentation);
    }
}