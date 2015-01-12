<?php


return array(
    'router' => array(
        'routes' => array(
            'subdomain' => array(
                'type' => 'Zend\Mvc\Router\Http\Hostname',
                'options' => array(
                    'route' => ':subdomain.concertticketsq.com',
                    //'priority' => 2,
                    'defaults' => array(
                        'controller' => 'Application\Controller\Event',
                        'action' => 'event'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'performerPage' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Event',
                                'action' => 'event'
                            )
                        )
                    ),
                    'ticketPage' => array(
                        'type' => 'Regex',
                        'options' => array(
                            'regex' => '/(?<city>[a-zA-Z0-9]+)\-(?<venue>(.*))\.html',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Ticket',
                                'action' => 'ticket'
                            ),
                            'spec' => '/%city%-%venue%.html'
                        )
                    ),
                    'ajaxTicketsPage' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/ajax/:action',
                            'constraints' => array(),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Ajax',
                                'action' => 'tickets'
                            )
                        )
                    )
                )
            ),
            'www' => array(
                'type' => 'Zend\Mvc\Router\Http\Hostname',
                'options' => array(
                    'route' => 'www.concertticketsq.com',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/',
                            'defaults' => array()
                        )
                    ),
                    'cityPage' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:city].html',
                            'constraints' => array(
                                'city' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\City',
                                'action' => 'city'
                            )
                        )
                    ),
                    'about' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/about.php',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Static',
                                'action' => 'about'
                            )
                        )
                    ),
                    'contact' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/contact.php',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Static',
                                'action' => 'contact'
                            )
                        )
                    ),
                    'help' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/help.php',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Static',
                                'action' => 'help'
                            )
                        )
                    ),
                    'third-party-connect' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout.html',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Logout',
                                'action' => 'logout'
                            )
                        )
                    ),
                    'searchPage' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/search.php',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Event',
                                'action' => 'search'
                            )
                        )
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator'
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo'
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Event' => 'Application\Controller\EventController',
            'Application\Controller\Ticket' => 'Application\Controller\TicketController',
            'Application\Controller\City' => 'Application\Controller\CityController',
            'Application\Controller\Ajax' => 'Application\Controller\AjaxController',
            'Application\Controller\Logout' => 'Application\Controller\LogoutController',
            'Application\Controller\Static' => 'Application\Controller\StaticController'
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/concertfilterstickets' => __DIR__ . '/../view/layout/concertfilterstickets.phtml',
            'layout/filtercities' => __DIR__ . '/../view/layout/filtercities.phtml',
            'layout/indexhead' => __DIR__ . '/../view/layout/indexhead.phtml',
            'layout/tickethead' => __DIR__ . '/../view/layout/tickethead.phtml',
            'layout/eventhead' => __DIR__ . '/../view/layout/eventhead.phtml',
            'layout/filterhome' => __DIR__ . '/../view/layout/filterhome.phtml',
            'layout/listingbrokerstickets' => __DIR__ . '/../view/layout/listingbrokerstickets.phtml',
            'layout/listingevent' => __DIR__ . '/../view/layout/listingevent.phtml',
            'layout/performerbox' => __DIR__ . '/../view/layout/performerbox.phtml',
            'layout/partialjs' => __DIR__ . '/../view/layout/partialjs_1.phtml',
            'layout/ticketconcertcontainer' => __DIR__ . '/../view/layout/ticketconcertcontainer.phtml',
            'layout/performerevents' => __DIR__ . '/../view/layout/performerevents.phtml',
            'layout/performerinformation' => __DIR__ . '/../view/layout/performerinformation.phtml',
            'layout/ticketmap' => __DIR__ . '/../view/layout/ticketmap.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/event/event' => __DIR__ . '/../view/application/event/event.phtml',
            'application/event/index' => __DIR__ . '/../view/application/event/index.phtml',
            'application/city/city' => __DIR__ . '/../view/application/city/city.phtml',
            'application/ticket/ticket' => __DIR__ . '/../view/application/ticket/ticket.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/no_event' => __DIR__ . '/../view/error/no_event.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'layout/search' => __DIR__ . '/../view/layout/search.phtml',
            'application/static/about' => __DIR__ . '/../view/application/static/about.phtml',
            'application/static/contact' => __DIR__ . '/../view/application/static/contact.phtml',
            'application/static/help' => __DIR__ . '/../view/application/static/help.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'image' => 'Application\View\Helper\Image',
            'generateContent' => 'Application\View\Helper\GenerateContent'
        )
    )
);
