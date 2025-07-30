<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Édition de Document</title>
    
</head>
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }

    #onlyoffice-editor {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<body>
    
    <div id="onlyoffice-editor" style="width: 100vw; height: 100vh;"></div>

    <script type="text/javascript" src="{{ $documentServerUrl }}/web-apps/apps/api/documents/api.js"></script>
    <script>
        var docEditor = new DocsAPI.DocEditor("onlyoffice-editor", {!! json_encode($config) !!},
        );
    </script>
</body>
</html>
