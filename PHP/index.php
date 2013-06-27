<html>
<head>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript">
    $(function() {
        // Formatted for readability
        var url = 'http://jkoehl-batterii-dev-server.appspot.com/loginsso/custom';
        var client_state = { account_id: 1001, community_id: 1001, redirect: 'http://jkoehl.dev.batterii.com/#' };

        url += '?' + $.param({ client_state: JSON.stringify(client_state) });
        $('#login-link').attr('href', url);
    });
    </script>
</head>
<body>
    <a id="login-link">Login to Batterii</a>
</body>
</html>