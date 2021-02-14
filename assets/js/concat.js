// Script is run via npm, so paths are relative to the location of package.json
var fs = require('fs');

var moduleList = [
	'./assets/js/modules/base.js',
	'./assets/js/modules/nav.js',
];

var out = moduleList.map(function(filePath) {
	return fs.readFileSync(filePath, 'utf-8');
})

fs.writeFileSync('./assets/js/main.js', out.join('\n'), 'utf-8');
console.log('main.js built.');