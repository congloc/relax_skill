// Route::get('provinces', 'LocationController@getProvince')->name('provinces');
/**
 * @api {get} /api/location/provinces Province list
 * @apiName GetProvinceList
 * @apiGroup Location
 * 
 * @apiSuccess {Number} id Province ID
 * @apiSuccess {String} name Province name
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "id": 2,
        "name": "test province",
        "wards": [
            {
                "id": 1,
                "name": "test 1 ward",
                "province_id": 2
            },
            {
                "id": 2,
                "name": "test 2 ward",
                "province_id": 2
            }
        ]
    }
 */


//Route::get('wards', 'LocationController@getWard')->name('wards');
/**
 * @api {get} /api/location/wards Ward list
 * @apiName GetWardList
 * @apiGroup Location
 * 
 * @apiSuccess {Number} id Province ID
 * @apiSuccess {String} name Ward name
 * 
 * @apiSuccessExample {type} Success-Response:
    {
        "id": 1,
        "name": "test ward name",
        "province_id": 2,
        "province": {
            "id": 2,
            "name": "test province name"
        }
    }
 */


