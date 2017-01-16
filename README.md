Test task on Yii2

The application allows to register a new user, upload pictures, rotate them and delete. It automatically adds a watermark to the picture during loading.

The app is made on Yii 2 Basic Template since we don't need extra CRUD functionality here. It's a demo app, so it has a bit reduced functionality e.g. it doesn't use access tokens and autologin.

The code is commented so the functions purpose should be clear.
The database dump is in the __sql dir. It contains no entries, so the only way to test the app is to follow all steps starting with the user registration.

The app template is basic for Yii2 - it uses Twitter Bootstrap and the default color scheme. Almost all default views were removed and added some app-specific: login/signup, upload pic/show all pictures.

Total time spent: about 20 hours