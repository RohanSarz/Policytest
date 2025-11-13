import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import avatar from './avatar'
/**
* @see \App\Http\Controllers\UserDataController::store
 * @see app/Http/Controllers/UserDataController.php:49
 * @route '/profile'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/profile',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\UserDataController::store
 * @see app/Http/Controllers/UserDataController.php:49
 * @route '/profile'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserDataController::store
 * @see app/Http/Controllers/UserDataController.php:49
 * @route '/profile'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const profile = {
    store,
avatar,
}

export default profile