import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminController::store
 * @see app/Http/Controllers/AdminController.php:41
 * @route '/admin/permissions'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/permissions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AdminController::store
 * @see app/Http/Controllers/AdminController.php:41
 * @route '/admin/permissions'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::store
 * @see app/Http/Controllers/AdminController.php:41
 * @route '/admin/permissions'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const permissions = {
    index,
store,
}

export default permissions