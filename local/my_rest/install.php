<!DOCTYPE html>
<html>
<head>
    <script src="//api.bitrix24.com/api/v1/"></script>
</head>
<body>
    <script>    
        if (BX24) {
            BX24.init( function () {
                new Promise ((resolve, reject) => {
                    BX24.callUnbind(
                        'ONCRMACTIVITYADD',
                        'https://ca43694.tw1.ru/local/my_rest/app.php',
                        1,
                        (result) => console.log(result)
                    );
                }).then(
                        new Promise (() => {
                            BX24.callBind(
                                'ONCRMACTIVITYADD',
                                'https://ca43694.tw1.ru/local/my_rest/app.php',
                                1,
                                (result) => console.log(result)
                            );
                        })
                    );

                BX24.installFinish();
                
            });
        }
    </script>
</body>
</html>