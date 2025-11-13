import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\ImageUploadController::upload
 * @see app/Http/Controllers/ImageUploadController.php:10
 * @route '/upload-image'
 */
export const upload = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})

upload.definition = {
    methods: ["post"],
    url: '/upload-image',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ImageUploadController::upload
 * @see app/Http/Controllers/ImageUploadController.php:10
 * @route '/upload-image'
 */
upload.url = (options?: RouteQueryOptions) => {
    return upload.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageUploadController::upload
 * @see app/Http/Controllers/ImageUploadController.php:10
 * @route '/upload-image'
 */
upload.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: upload.url(options),
    method: 'post',
})
const image = {
    upload,
}

export default image