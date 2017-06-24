function f(n){
	return n < 10 ? '0' + n : n;
}
var page = require('webpage').create(),
    system = require('system'),
    address, output, size;
var date = new Date();
var time = 	f(date.getDate())+'-'+
		f((date.getMonth() + 1))+'-'+
		f(date.getFullYear())+'  '+
		f(date.getHours()) + ":" +
		f(date.getMinutes()) + ":" +
		f(date.getSeconds());

if (system.args.length < 3 || system.args.length > 5) {
    console.log(system.args);
    console.log('Usage: rasterize.js URL filename [paperwidth*paperheight|paperformat] [zoom]');
    console.log('  paper (pdf output) examples: "5in*7.5in", "10cm*20cm", "A4", "Letter"');
    phantom.exit(1);
} else {
    address = system.args[1];
    output = system.args[2];

    if (system.args.length > 3 && system.args[2].substr(-4) === ".pdf") {
        size = system.args[3].split('*');
        page.paperSize = size.length === 2 ? {
        						 width: size[0],
        						 height: size[1], 
        						 margin: {top:'0.2cm',right:'0.2cm',left:'0.2cm',bottom:'0.2cm'},
        						 header: {
							height: "0.5cm",
							contents: phantom.callback(function(pageNum, numPages) {
								return "<span style='float:right;font-size:12px;font-family:arial,helvetica,sans-serif;'>" + time + "</span>";
							})
						},
						footer: {
							height: "0.5cm",
							contents: phantom.callback(function(pageNum, numPages) {
								if(numPages>1)
									return "<span style='float:right;font-size:12px;font-family:arial,helvetica,sans-serif;'>" + pageNum + " / " + numPages + "</span>";
								else return "<span style='float:right;font-size:12px;font-family:arial,helvetica,sans-serif;'>&nbsp;</span>"
							})
						}

        					     }
                                           : { 
                                                format: system.args[3], orientation: 'portrait', margin: '0.2cm'
                                            };
	// page.paperSize = {
	// 	width: '8.5in',
	// 	height: '11in',
	// 	header: {
	// 		height: "1cm",
	// 		contents: phantom.callback(function(pageNum, numPages) {
	// 			return "<h1>Header <span style='float:right'>" + pageNum + " / " + numPages + "</span></h1>";
	// 		})
	// 	},
	// 	footer: {
	// 		height: "1cm",
	// 		contents: phantom.callback(function(pageNum, numPages) {
	// 			return "<h1>Footer <span style='float:right'>" + pageNum + " / " + numPages + "</span></h1>";
	// 		})
	// 	}
	// }
    } else {
        size = system.args[3].split('*');
        page.viewportSize = {width: size[0], height: size[1]};
    }
    if (system.args.length > 4) {
        page.zoomFactor = system.args[4];
    }
    page.open(address, function (status) {
        if (status !== 'success') {
            console.log('Unable to load the address!');
            phantom.exit();
        } else {
            window.setTimeout(function () {
                console.log('ok');
                if((size[0]<800 && size[1]<800 ) || (system.args.length > 3 && system.args[2].substr(-4) === ".pdf")){
                    page.render(output);
                }else{
                    page.render(output,{format: 'png', quality: '60'});
                }
                phantom.exit();
            }, 200);
        }
    });
}
