import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\UserDataController::dashboardView
 * @see app/Http/Controllers/UserDataController.php:21
 * @route '/dashboard'
 */
export const dashboardView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardView.url(options),
    method: 'get',
})

dashboardView.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\UserDataController::dashboardView
 * @see app/Http/Controllers/UserDataController.php:21
 * @route '/dashboard'
 */
dashboardView.url = (options?: RouteQueryOptions) => {
    return dashboardView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserDataController::dashboardView
 * @see app/Http/Controllers/UserDataController.php:21
 * @route '/dashboard'
 */
dashboardView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboardView.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\UserDataController::dashboardView
 * @see app/Http/Controllers/UserDataController.php:21
 * @route '/dashboard'
 */
dashboardView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboardView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\UserDataController::profileView
 * @see app/Http/Controllers/UserDataController.php:15
 * @route '/profile'
 */
export const profileView = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profileView.url(options),
    method: 'get',
})

profileView.definition = {
    methods: ["get","head"],
    url: '/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\UserDataController::profileView
 * @see app/Http/Controllers/UserDataController.php:15
 * @route '/profile'
 */
profileView.url = (options?: RouteQueryOptions) => {
    return profileView.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserDataController::profileView
 * @see app/Http/Controllers/UserDataController.php:15
 * @route '/profile'
 */
profileView.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profileView.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\UserDataController::profileView
 * @see app/Http/Controllers/UserDataController.php:15
 * @route '/profile'
 */
profileView.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: profileView.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\UserDataController::store
 * @see app/Http/Controllers/UserDataController.php:36
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
 * @see app/Http/Controllers/UserDataController.php:36
 * @route '/profile'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserDataController::store
 * @see app/Http/Controllers/UserDataController.php:36
 * @route '/profile'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\UserDataController::updateAvatar
 * @see app/Http/Controllers/UserDataController.php:57
 * @route '/profile/avatar'
 */
export const updateAvatar = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateAvatar.url(options),
    method: 'post',
})

updateAvatar.definition = {
    methods: ["post"],
    url: '/profile/avatar',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\UserDataController::updateAvatar
 * @see app/Http/Controllers/UserDataController.php:57
 * @route '/profile/avatar'
 */
updateAvatar.url = (options?: RouteQueryOptions) => {
    return updateAvatar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\UserDataController::updateAvatar
 * @see app/Http/Controllers/UserDataController.php:57
 * @route '/profile/avatar'
 */
updateAvatar.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateAvatar.url(options),
    method: 'post',
})
const UserDataController = { dashboardView, profileView, store, updateAvatar }

export default UserDataController