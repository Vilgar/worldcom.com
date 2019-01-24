<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Worldcom</title>
        <script src="assets/common.js"></script>
        <style>td, th { border: 1px solid #999; padding: 0.5rem; }</style>
    </head>
    <body>
        <select id="country">
            <option value="" disabled selected>Select Country</option>
        </select>
        <input type="text" id="zip_code" placeholder="Write Zip Code">
        <button onclick="load()">Submit</button>
        <div id="result"></div>
    </body>
</html>