import ImageUploadController from './ImageUploadController'
import PostController from './PostController'
import UserDataController from './UserDataController'
import AuthController from './AuthController'
import UserController from './UserController'
import AdminController from './AdminController'
const Controllers = {
    ImageUploadController: Object.assign(ImageUploadController, ImageUploadController),
PostController: Object.assign(PostController, PostController),
UserDataController: Object.assign(UserDataController, UserDataController),
AuthController: Object.assign(AuthController, AuthController),
UserController: Object.assign(UserController, UserController),
AdminController: Object.assign(AdminController, AdminController),
}

export default Controllers