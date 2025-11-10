import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/login'
 */
const Controllerb6041c76e8e1cd791f8f89d035d48611 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllerb6041c76e8e1cd791f8f89d035d48611.url(options),
    method: 'get',
})

Controllerb6041c76e8e1cd791f8f89d035d48611.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/login'
 */
Controllerb6041c76e8e1cd791f8f89d035d48611.url = (options?: RouteQueryOptions) => {
    return Controllerb6041c76e8e1cd791f8f89d035d48611.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/login'
 */
Controllerb6041c76e8e1cd791f8f89d035d48611.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllerb6041c76e8e1cd791f8f89d035d48611.url(options),
    method: 'get',
})
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/login'
 */
Controllerb6041c76e8e1cd791f8f89d035d48611.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controllerb6041c76e8e1cd791f8f89d035d48611.url(options),
    method: 'head',
})

    /**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/register'
 */
const Controllere9819db9819a1d19b38dd89a0c4218c4 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllere9819db9819a1d19b38dd89a0c4218c4.url(options),
    method: 'get',
})

Controllere9819db9819a1d19b38dd89a0c4218c4.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/register'
 */
Controllere9819db9819a1d19b38dd89a0c4218c4.url = (options?: RouteQueryOptions) => {
    return Controllere9819db9819a1d19b38dd89a0c4218c4.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/register'
 */
Controllere9819db9819a1d19b38dd89a0c4218c4.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controllere9819db9819a1d19b38dd89a0c4218c4.url(options),
    method: 'get',
})
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:9
 * @route '/register'
 */
Controllere9819db9819a1d19b38dd89a0c4218c4.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controllere9819db9819a1d19b38dd89a0c4218c4.url(options),
    method: 'head',
})

const Controller = {
    '/login': Controllerb6041c76e8e1cd791f8f89d035d48611,
    '/register': Controllere9819db9819a1d19b38dd89a0c4218c4,
}

export default Controller