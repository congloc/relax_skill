// Route::post('register', 'AuthController@register');
/**
 * @api {post} /api/auth/register Register User
 * @apiName RegisterUser
 * @apiGroup Auth
 * 
 * @apiParam  {String} name Name
 * @apiParam  {String} username User Name
 * @apiParam  {String} email Email
 * @apiParam  {String} password Password
 * @apiParam  {String} type Type
 * @apiParam  {String} ref Ref link
 * 
 * @apiSuccess (201) {Number} id User ID
 * @apiSuccess (201) {String} name Name
 * @apiSuccess (201) {String} username User Name
 * @apiSuccess (201) {String} email
 * @apiSuccess (201) {String} type Type 
 * @apiSuccess (201) {String} ref Ref link 
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "status": 200,
        "message": "Please check your email to verify account by activation code"
    }
 */


//Route::post('login', 'AuthController@login')->name('login');
/**
 * @api {post} /api/auth/login Login
 * @apiName Login
 * @apiGroup Auth
 * 
 * @apiParam {String} username User name
 * @apiParam {String} password Password
 * 
 * @apiSuccessExample {json} Success-Response:
    {

    }
 * 
 */

/**
 * @api {post} /api/auth/verify-code Verify Code
 * @apiName verify-code
 * @apiGroup Auth
 * 
 * @apiParam  {String} email Email
 * @apiParam  {String} code Code
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "status": 200,
        "message": 'Your account has been actived successfully.',
    }
 */

 /**
 * @api {post} /api/auth/send-code-forgot-password Send mail forget password
 * @apiName send-code-forgot-password
 * @apiGroup Auth
 * 
 * @apiParam  {String} email Email
 * 
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "status": 200,
        "message": 'Your code has been sent successfully.',
    }
 */

 
 /**
 * @api {post} /api/auth/send-code-reset-password Send mail reset password
 * @apiName send-code-reset-password
 * @apiGroup Auth
 * 
 * @apiParam  {String} email Email
 * 
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "status": 200,
        "message": 'Your code has been sent successfully.',
    }
 */

/**
 * @api {post} /api/auth/check-code Check Code
 * @apiName check-code
 * @apiGroup Auth
 * 
 * @apiParam  {String} email Email
 * @apiParam  {String} code Code
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "status": 200,
        "message": 'Success',
    }
 */

 /**
 * @api {post} /api/auth/update-password Update password
 * @apiName update password
 * @apiGroup Auth
 * 
 * @apiParam  {String} email Email
 * @apiParam  {String} password Password
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "status": 200,
        "message": 'Your password has been updated successful.',
    }
 */

  /**
 * @api {get} /api/profile Get Profile
 * @apiName get profile
 * @apiGroup Profile
 * 
 * @apiParam  {String} Bear token Authorization
 * 
 * @apiSuccessExample {type} Success-Response:
    {
    "status": 200,
    "message": "Get data is success.",
    "data": {
        "id": 17,
        "name": "relax",
        "email": "ngocduoc@vutatech.vn",
        "username": "relax",
        "email_verified_at": null,
        "google2fa_secret": null,
        "google2fa_status": 0,
        "status": 1,
        "type": "1",
        "ref": "xxxxxx",
        "code": 543697,
        "created_at": "2021-04-28T07:16:26.000000Z",
        "updated_at": "2021-04-28T07:16:26.000000Z"
    }
   }
 */