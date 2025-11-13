import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:14
 * @route '/admin'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:14
 * @route '/admin'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:14
 * @route '/admin'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AdminController::index
 * @see app/Http/Controllers/AdminController.php:14
 * @route '/admin'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminController::roles
 * @see app/Http/Controllers/AdminController.php:53
 * @route '/admin/roles'
 */
export const roles = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: roles.url(options),
    method: 'get',
})

roles.definition = {
    methods: ["get","head"],
    url: '/admin/roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminController::roles
 * @see app/Http/Controllers/AdminController.php:53
 * @route '/admin/roles'
 */
roles.url = (options?: RouteQueryOptions) => {
    return roles.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::roles
 * @see app/Http/Controllers/AdminController.php:53
 * @route '/admin/roles'
 */
roles.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: roles.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AdminController::roles
 * @see app/Http/Controllers/AdminController.php:53
 * @route '/admin/roles'
 */
roles.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: roles.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminController::storeRole
 * @see app/Http/Controllers/AdminController.php:67
 * @route '/admin/roles'
 */
export const storeRole = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeRole.url(options),
    method: 'post',
})

storeRole.definition = {
    methods: ["post"],
    url: '/admin/roles',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AdminController::storeRole
 * @see app/Http/Controllers/AdminController.php:67
 * @route '/admin/roles'
 */
storeRole.url = (options?: RouteQueryOptions) => {
    return storeRole.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::storeRole
 * @see app/Http/Controllers/AdminController.php:67
 * @route '/admin/roles'
 */
storeRole.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeRole.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AdminController::updateRole
 * @see app/Http/Controllers/AdminController.php:84
 * @route '/admin/roles/{role}'
 */
export const updateRole = (args: { role: number | { id: number } } | [role: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateRole.url(args, options),
    method: 'put',
})

updateRole.definition = {
    methods: ["put"],
    url: '/admin/roles/{role}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\AdminController::updateRole
 * @see app/Http/Controllers/AdminController.php:84
 * @route '/admin/roles/{role}'
 */
updateRole.url = (args: { role: number | { id: number } } | [role: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { role: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { role: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    role: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        role: typeof args.role === 'object'
                ? args.role.id
                : args.role,
                }

    return updateRole.definition.url
            .replace('{role}', parsedArgs.role.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::updateRole
 * @see app/Http/Controllers/AdminController.php:84
 * @route '/admin/roles/{role}'
 */
updateRole.put = (args: { role: number | { id: number } } | [role: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateRole.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\AdminController::deleteRole
 * @see app/Http/Controllers/AdminController.php:101
 * @route '/admin/roles/{role}'
 */
export const deleteRole = (args: { role: number | { id: number } } | [role: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteRole.url(args, options),
    method: 'delete',
})

deleteRole.definition = {
    methods: ["delete"],
    url: '/admin/roles/{role}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\AdminController::deleteRole
 * @see app/Http/Controllers/AdminController.php:101
 * @route '/admin/roles/{role}'
 */
deleteRole.url = (args: { role: number | { id: number } } | [role: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { role: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { role: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    role: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        role: typeof args.role === 'object'
                ? args.role.id
                : args.role,
                }

    return deleteRole.definition.url
            .replace('{role}', parsedArgs.role.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::deleteRole
 * @see app/Http/Controllers/AdminController.php:101
 * @route '/admin/roles/{role}'
 */
deleteRole.delete = (args: { role: number | { id: number } } | [role: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteRole.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\AdminController::users
 * @see app/Http/Controllers/AdminController.php:108
 * @route '/admin/users'
 */
export const users = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})

users.definition = {
    methods: ["get","head"],
    url: '/admin/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminController::users
 * @see app/Http/Controllers/AdminController.php:108
 * @route '/admin/users'
 */
users.url = (options?: RouteQueryOptions) => {
    return users.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::users
 * @see app/Http/Controllers/AdminController.php:108
 * @route '/admin/users'
 */
users.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AdminController::users
 * @see app/Http/Controllers/AdminController.php:108
 * @route '/admin/users'
 */
users.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: users.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminController::storeUser
 * @see app/Http/Controllers/AdminController.php:119
 * @route '/admin/users'
 */
export const storeUser = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeUser.url(options),
    method: 'post',
})

storeUser.definition = {
    methods: ["post"],
    url: '/admin/users',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AdminController::storeUser
 * @see app/Http/Controllers/AdminController.php:119
 * @route '/admin/users'
 */
storeUser.url = (options?: RouteQueryOptions) => {
    return storeUser.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::storeUser
 * @see app/Http/Controllers/AdminController.php:119
 * @route '/admin/users'
 */
storeUser.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeUser.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AdminController::deleteUser
 * @see app/Http/Controllers/AdminController.php:141
 * @route '/admin/users/{user}'
 */
export const deleteUser = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteUser.url(args, options),
    method: 'delete',
})

deleteUser.definition = {
    methods: ["delete"],
    url: '/admin/users/{user}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\AdminController::deleteUser
 * @see app/Http/Controllers/AdminController.php:141
 * @route '/admin/users/{user}'
 */
deleteUser.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { user: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    user: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        user: typeof args.user === 'object'
                ? args.user.id
                : args.user,
                }

    return deleteUser.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::deleteUser
 * @see app/Http/Controllers/AdminController.php:141
 * @route '/admin/users/{user}'
 */
deleteUser.delete = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteUser.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\AdminController::permissions
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
export const permissions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions.url(options),
    method: 'get',
})

permissions.definition = {
    methods: ["get","head"],
    url: '/admin/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminController::permissions
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
permissions.url = (options?: RouteQueryOptions) => {
    return permissions.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::permissions
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
permissions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: permissions.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AdminController::permissions
 * @see app/Http/Controllers/AdminController.php:32
 * @route '/admin/permissions'
 */
permissions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: permissions.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminController::storePermission
 * @see app/Http/Controllers/AdminController.php:41
 * @route '/admin/permissions'
 */
export const storePermission = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storePermission.url(options),
    method: 'post',
})

storePermission.definition = {
    methods: ["post"],
    url: '/admin/permissions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AdminController::storePermission
 * @see app/Http/Controllers/AdminController.php:41
 * @route '/admin/permissions'
 */
storePermission.url = (options?: RouteQueryOptions) => {
    return storePermission.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::storePermission
 * @see app/Http/Controllers/AdminController.php:41
 * @route '/admin/permissions'
 */
storePermission.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storePermission.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AdminController::posts
 * @see app/Http/Controllers/AdminController.php:148
 * @route '/admin/posts'
 */
export const posts = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: posts.url(options),
    method: 'get',
})

posts.definition = {
    methods: ["get","head"],
    url: '/admin/posts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AdminController::posts
 * @see app/Http/Controllers/AdminController.php:148
 * @route '/admin/posts'
 */
posts.url = (options?: RouteQueryOptions) => {
    return posts.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::posts
 * @see app/Http/Controllers/AdminController.php:148
 * @route '/admin/posts'
 */
posts.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: posts.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AdminController::posts
 * @see app/Http/Controllers/AdminController.php:148
 * @route '/admin/posts'
 */
posts.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: posts.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AdminController::updatePostStatus
 * @see app/Http/Controllers/AdminController.php:159
 * @route '/admin/posts/{post}/status'
 */
export const updatePostStatus = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updatePostStatus.url(args, options),
    method: 'patch',
})

updatePostStatus.definition = {
    methods: ["patch"],
    url: '/admin/posts/{post}/status',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\AdminController::updatePostStatus
 * @see app/Http/Controllers/AdminController.php:159
 * @route '/admin/posts/{post}/status'
 */
updatePostStatus.url = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    post: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        post: args.post,
                }

    return updatePostStatus.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::updatePostStatus
 * @see app/Http/Controllers/AdminController.php:159
 * @route '/admin/posts/{post}/status'
 */
updatePostStatus.patch = (args: { post: string | number } | [post: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updatePostStatus.url(args, options),
    method: 'patch',
})
const AdminController = { index, roles, storeRole, updateRole, deleteRole, users, storeUser, deleteUser, permissions, storePermission, posts, updatePostStatus }

export default AdminController