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


