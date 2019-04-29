<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <title>Open Twitter</title>
    </head>

    <body>
        <div style="width: 0; height: 0; overflow: hidden;">
            <iframe id="launch_frame" name="launch_frame"> </iframe>
        </div>
        <script>
            window.onload = function() {
                launchApp();
            }
            function launchApp() {
                var id = <?php echo json_encode($id); ?>;
                var normal_url = 'https://twitter.com/' + id;
                var userAgent = navigator.userAgent.toLowerCase();
                if (userAgent.search(/iphone|ipad|ipod|android/) > -1) {
                    launch_frame.location.href = 'twitter://user?screen_name=' + id;
                    setTimeout(function() {
                        location.href = normal_url;
                    }, 500);
                } else {
                    document.location = normal_url;
                }
            }
        </script>
    </body>

</html>