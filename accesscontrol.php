<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
if($_SERVER["REQUEST_METHOD"] == "OPTIONS") exit();
// before sending CORS request, modern browsers often make "pre-flight request" in order to see which headers are allowed/accepted from custom origin
// that request must be answered with status code 200 OK, and must contain header Acces-Control-Allow-Headers