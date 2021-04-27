define({ "api": [
  {
    "type": "post",
    "url": "/api/auth/login",
    "title": "Login",
    "name": "Login",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>User name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Password</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/apidocs/Auth.js",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/auth/register",
    "title": "Register User",
    "name": "RegisterUser",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>User Name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>Password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Type</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ref",
            "description": "<p>Ref link</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "201": [
          {
            "group": "201",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>User ID</p>"
          },
          {
            "group": "201",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name</p>"
          },
          {
            "group": "201",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>User Name</p>"
          },
          {
            "group": "201",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": ""
          },
          {
            "group": "201",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Type</p>"
          },
          {
            "group": "201",
            "type": "String",
            "optional": false,
            "field": "ref",
            "description": "<p>Ref link</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": 200,\n    \"message\": \"Please check your email to verify account by activation code\"\n}",
          "type": "type"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/apidocs/Auth.js",
    "groupTitle": "Auth"
  }
] });
