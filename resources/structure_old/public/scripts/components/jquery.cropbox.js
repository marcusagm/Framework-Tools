;(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else {
        factory(jQuery);
    }
}(function ($) {
    'use strict';
    var cropbox = function (options, el) {
        var el = el || $(options.imageInput),
            obj = {
                state: {},
                width: options.width || 200,
                height: options.height ||200,
                ratio: 1,
                cropRatio: 1,
                options: options,
                viewportId: options.viewportId || 'crop',
                moveInputFileTo: '#' + options.viewportId + ' .btn-file',
                inputName: el.attr('name'),
                template: '' +
                    '<div class="crop-viewport" id="' + options.viewportId  + '">' +
                        '<div class="crop-area">' +
                            '<div class="crop-thumbbox"></div>' +
                            '<div class="crop-spinner"><i class="fa fa-fw fa-spin fa-spinner fa-5x"></i></div>' +
                            '<div class="crop-empty">Selecione uma imagem.</div>' +
                            '<video class="crop-webcam-player"></video>' +
                        '</div>' +
                        '<div class="crop-action">' +
                            '<span class="btn btn-default btn-file">' +
                                '<i class="fa fa-fw fa-upload"></i>' +
                                'Selecionar imagem' +
                            '</span>' +
                            '<div class="btn-group">' +
                                '<button class="crop-webcam btn btn-default"><i class="fa fa-fw fa-camera"></i></button>' +
                                '<button class="crop-zoomin btn btn-default"><i class="fa fa-fw fa-search-plus"></i></button>' +
                                '<button class="crop-zoomout btn btn-default"><i class="fa fa-fw fa-search-minus"></i></button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="crop-action-webcam">' +
                            '<div class="btn-group btn-group-justified">' +
                                '<div class="btn-group">' +
                                    '<button class="crop-webcam-capture btn btn-default"><i class="fa fa-fw fa-camera"></i> Capturar</button>' +
                                '</div>' +
                                '<div class="btn-group">' +
                                    '<button class="crop-webcam-cancel btn btn-default"><i class="fa fa-fw fa-ban"></i> cancelar</button>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<input type="hidden" class="crop-data" name="' + el.attr('name') + '_data" id="' + el.attr('name') + '_data" value="">' +
                    '</div>',
                imageInput: el,
                imageBox: null,
                thumbBox: null,
                spinner: null,
                empty: null,
                webcamPlayer: null,
                actionBar: null,
                actionBarWebcam: null,
                btnZoomIn: null,
                btnZoomOut: null,
                btnWebcam: null,
                btnWebcamCapture: null,
                btnWebcamCancel: null,
                webcamStream: null,
                image: new Image(),
                getDataURL: function () {
                    var width = this.thumbBox.width(),
                        height = this.thumbBox.height(),
                        canvas = document.createElement("canvas"),
                        dim = obj.imageBox.css('background-position').split(' '),
                        size = obj.imageBox.css('background-size').split(' '),
                        dx = (parseInt(dim[0]) - obj.imageBox.width() / 2 + width / 2 ) / this.cropRatio,
                        dy = (parseInt(dim[1]) - obj.imageBox.height() / 2 + height / 2 ) / this.cropRatio,
                        dw = parseInt(size[0]) / this.cropRatio,
                        dh = parseInt(size[1]) / this.cropRatio,
                        sh = parseInt(this.image.height),
                        sw = parseInt(this.image.width);

                    canvas.width = this.width;
                    canvas.height = this.height;
                    var context = canvas.getContext("2d");
                    context.drawImage(this.image, 0, 0, sw, sh, dx, dy, dw, dh);
                    var imageData = canvas.toDataURL('image/png');
                    return imageData;
                },
                getBlob: function () {
                    var imageData = this.getDataURL();
                    var b64 = imageData.replace('data:image/png;base64,', '');
                    var binary = atob(b64);
                    var array = [];
                    for (var i = 0; i < binary.length; i++) {
                        array.push(binary.charCodeAt(i));
                    }
                    return  new Blob([new Uint8Array(array)], {type: 'image/png'});
                },
                zoomIn: function () {
                    this.ratio *= 1.1;
                    setBackground();
                },
                zoomOut: function () {
                    this.ratio *= 0.9;
                    setBackground();
                },
                startWebcam: function () {
                    openWebcamDialog();
                },
                stopWebcam: function () {
                    closeWebcamDialog();
                },
                captureWebcam: function() {
                    captureWebcam();
                }
            },
            setThumbBoxSize = function () {
                var viewportWidth = obj.imageBox.width(),
                    viewportHeight = obj.imageBox.height(),
                    margin = 20,
                    maxWidth = viewportWidth - margin,
                    maxHeight = viewportHeight - margin;

                if (maxWidth >= obj.width && maxHeight >= obj.height) {
                    obj.cropRatio = 1;
                } else {
                    if (maxWidth <= maxHeight) {
                        obj.cropRatio = maxWidth / obj.width;
                    } else {
                        obj.cropRatio = maxHeight / obj.height;
                    }
                }

                obj.thumbBox.css({
                    width: obj.width * obj.cropRatio,
                    height: obj.height * obj.cropRatio,
                    marginLeft: - obj.width * obj.cropRatio / 2,
                    marginTop: - obj.height * obj.cropRatio / 2
                });
            },
            setBackground = function () {
                var w = parseInt(obj.image.width) * obj.ratio;
                var h = parseInt(obj.image.height) * obj.ratio;

                var pw = (obj.imageBox.width() - w) / 2;
                var ph = (obj.imageBox.height() - h) / 2;

                obj.imageBox.css({
                    'background-image': 'url(' + obj.image.src + ')',
                    'background-size': w + 'px ' + h + 'px',
                    'background-position': pw + 'px ' + ph + 'px',
                    'background-repeat': 'no-repeat'
                });
            },
            imgMouseDown = function (e) {
                e.stopImmediatePropagation();

                obj.state.dragable = true;
                obj.state.mouseX = e.clientX;
                obj.state.mouseY = e.clientY;
            },
            imgMouseMove = function (e) {
                e.stopImmediatePropagation();

                if (obj.state.dragable) {
                    var x = e.clientX - obj.state.mouseX;
                    var y = e.clientY - obj.state.mouseY;

                    var bg = obj.imageBox.css('background-position').split(' ');

                    var bgX = x + parseInt(bg[0]);
                    var bgY = y + parseInt(bg[1]);

                    obj.imageBox.css('background-position', bgX + 'px ' + bgY + 'px');

                    obj.state.mouseX = e.clientX;
                    obj.state.mouseY = e.clientY;
                }
            },
            imgMouseUp = function (e) {
                e.stopImmediatePropagation();
                obj.state.dragable = false;
            },
            zoomImage = function (e) {
                e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0 ? obj.ratio *= 1.1 : obj.ratio *= 0.9;
                setBackground();
            },
            checkSupportToGetUserMedia = function () {
                navigator.getUserMedia = navigator.getUserMedia || // Opera
                                         navigator.webkitGetUserMedia || // Chrome, Safari
                                         navigator.mozGetUserMedia || // Mozilla
                                         navigator.msGetUserMedia; // Ie
                if (navigator.getUserMedia) {
                    return true;
                }
                return false;
            },
            checkSupportToURL = function () {
                window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
                if (window.URL && window.URL.createObjectURL) {
                    return true;
                }
                return false;
            },
            openWebcamDialog = function() {
                if (checkSupportToGetUserMedia() === false || checkSupportToURL() === false) {
                    bootbox.alert("Seu navegador não suporte a tecnologia de WebCam HTML5");
                } else {
                    navigator.getUserMedia(
                        {video: true, audio: false},
                        startStream,
                        streamError
                    );
                }
            },
            closeWebcamDialog = function () {
                var player = obj.webcamPlayer.get(0);

                player.pause();
                obj.webcamStream.getTracks()[0].stop();

                obj.thumbBox.hide();
                obj.empty.show();
                obj.spinner.hide();
                obj.webcamPlayer.hide();

                obj.actionBar.show();
                obj.actionBarWebcam.hide();
            },
            startStream = function(stream) {
                var player = obj.webcamPlayer.get(0);
                obj.thumbBox.hide();
                obj.empty.hide();
                obj.spinner.hide();
                obj.webcamPlayer.show();

                obj.image.src = null;
                setBackground();

                obj.webcamStream = stream;
                player.src = window.URL.createObjectURL(stream);
                player.play();

                obj.actionBar.hide();
                obj.actionBarWebcam.show();
            },
            streamError = function() {
                bootbox.alert("Erro na aplicação " + e);
            },
            captureWebcam = function() {
                var player = obj.webcamPlayer.get(0),
                    canvas = document.createElement("canvas"),
                    width = player.videoWidth,
                    height = player.videoHeight;

                canvas.width = width;
                canvas.height = height;
                var context = canvas.getContext("2d");
                context.drawImage(player, 0, 0, width, height);

                obj.image.src = canvas.toDataURL('image/png');

                closeWebcamDialog();
                obj.thumbBox.hide();
                obj.empty.hide();
                obj.spinner.show();
                obj.image.onload = function () {
                    setBackground();
                    obj.spinner.hide();
                    obj.thumbBox.show();

                    obj.imageBox.on('mousedown touchstart', imgMouseDown);
                    obj.imageBox.on('mousemove touchmove', imgMouseMove);
                    $(window).on('mouseup touchend', imgMouseUp);
                    obj.imageBox.on('mousewheel DOMMouseScroll', zoomImage);
                };
                obj.imageBox.on('remove', function () {
                    $(window).off('mouseup touchend', imgMouseUp);
                });
            };

        var viewport = $(obj.template);
        el.before(viewport);
        el.prependTo(obj.moveInputFileTo);

        el.on('change', function(){
            var reader = new FileReader();
            reader.onload = function(e) {
                obj.image.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);

            obj.thumbBox.hide();
            obj.empty.hide();
            obj.spinner.show();
            obj.image.onload = function () {
                setBackground();
                obj.spinner.hide();
                obj.thumbBox.show();

                obj.imageBox.on('mousedown touchstart', imgMouseDown);
                obj.imageBox.on('mousemove touchmove', imgMouseMove);
                $(window).on('mouseup touchend', imgMouseUp);
                obj.imageBox.on('mousewheel DOMMouseScroll', zoomImage);
            };
            obj.imageBox.on('remove', function () {
                $(window).off('mouseup touchend', imgMouseUp);
            });
        });

        obj.imageBox = viewport.find('.crop-area');
        obj.thumbBox = viewport.find('.crop-thumbbox');
        obj.empty = viewport.find('.crop-empty');
        obj.spinner = viewport.find('.crop-spinner');
        obj.webcamPlayer = viewport.find('.crop-webcam-player');

        obj.actionBar = viewport.find('.crop-action');
        obj.actionBarWebcam = viewport.find('.crop-action-webcam');

        obj.btnZoomIn = viewport.find('.crop-zoomin');
        obj.btnZoomOut = viewport.find('.crop-zoomout');
        obj.btnWebcam = viewport.find('.crop-webcam');
        obj.btnWebcamCapture = viewport.find('.crop-webcam-capture');
        obj.btnWebcamCancel = viewport.find('.crop-webcam-cancel');

        setThumbBoxSize();
        obj.thumbBox.hide();
        obj.empty.show();

        obj.btnZoomIn.on('click', function() {
            obj.zoomIn();
            return false;
        });
        obj.btnZoomOut.on('click', function() {
            obj.zoomOut();
            return false;
        });
        obj.btnWebcam.on('click', function() {
            obj.startWebcam();
            return false;
        });
        obj.btnWebcamCancel.on('click', function() {
            obj.stopWebcam();
            return false;
        });
        obj.btnWebcamCapture.on('click', function() {
            obj.captureWebcam();
            return false;
        });

        $(window).on('resize', setThumbBoxSize);


        return obj;
    };

    jQuery.fn.cropbox = function (options) {
        return new cropbox(options, this);
    };
}));