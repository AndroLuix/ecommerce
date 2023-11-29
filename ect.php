/* $projectPath = realpath(__DIR__);
echo "project path = " . $projectPath;

$publicPath = $_SERVER['DOCUMENT_ROOT'];
echo "<br>public path = " . $publicPath;

$request = $_SERVER['REQUEST_URI'];
echo '<br>Request = ' . $request;

// Imposta il prefisso manualmente
$prefixToRemove = '/ecommerce/';
echo '<br>Prefix to remove = ' . $prefixToRemove;

// Rimuovi il prefisso dalla richiesta
$requestWithoutPrefix = (strpos($request, $prefixToRemove) === 0) ? substr($request, strlen($prefixToRemove)) : $request;
// Rimuovi eventuali barre in eccesso dal percorso della richiesta
$requestWithoutPrefix = trim($requestWithoutPrefix, '/');

echo '<br>requestWithoutPrefix = ' . $requestWithoutPrefix; */