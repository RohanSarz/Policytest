import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\UserDataController::update
 * @see app/Http/Controllers/UserDataController.php:70
 * @route '/profile/avatar'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/profile/avatar',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\UserDataController::update
 * @see app/Http/Controllers/UserDataController.php:70
 * @route '/profile/avatar'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserDataController::update
 * @see app/Http/Controllers/UserDataController.php:70
 * @route '/profile/avatar'
 */
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})
const avatar = {
    update,
}

export default avatar