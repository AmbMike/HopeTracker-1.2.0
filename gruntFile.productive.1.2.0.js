/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 12:58 PM
 */


var paths = {
    cwd : 'site/cwd/',
    scss : 'site/cwd/sass/',
    public : 'site/public/',
    c_views : 'site/cwd/views/',
    p_views : 'site/public/views/',
    c_js : 'site/cwd/js/',
    c_js_p : 'site/public/js/',
    c_js_plugs : 'site/cwd/js/concats/plugs/',
    c_js_c : 'site/cwd/js/concats/',
    c_js_form : 'site/cwd/js/concats/forms/',
    c_js_crop : 'mod/croppic/',
    c_crop_asset_j : 'mod/croppic/assets/js/',
    c_js_widgets : 'site/cwd/js/concats/widgets/'
};

module.exports = function(grunt){
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            dist: {
                options:{
                    style: 'compressed'
                },
                files: [{
                    expand: true,
                    cwd: 'site/cwd/sass',
                    src: [
                        'main.scss'
                        //'admin.scss'
                    ],
                    dest: 'site/public/css',
                    ext: '.css'
                }]
            }
        },
        htmlclean: {
            deploy: {
                expand: true,
                cwd: paths.c_views,
                src: '**/*.php',
                //src: '**/admin/*.php',

                dest: paths.p_views
            }
        },

        uglify: {
            options: {
                mangle: false,
                beautify: true
            },
            my_target: {
                files: {
                    'site/public/js/main.js': [
                        paths.c_js + 'global-variables.js',
                        paths.c_js + 'jquery-3-1-1.js',
                        paths.c_js_c + '*.js',
                        'bower_components/bootstrapvalidator/dist/js/bootstrapValidator.js',
                        //'mod/tinymce/tinymce.min.js',
                        'bower_components/jquery_lazyload/jquery.lazyload.js',
                        paths.c_js_crop + 'croppic.js',
                        paths.c_crop_asset_j + 'main.js',
                        paths.c_crop_asset_j + 'jquery.mousewheel.min.js',
                        'bower_components/jquery-ui/jquery-ui.min.js',
                        paths.c_js_plugs + 'mg-validator.js',
                        paths.c_js_form + 'form-one.js',
                        paths.c_js_form + 'sign-in.js',
                        paths.c_js_form + 'journal-entry-form.js',
                        paths.c_js_widgets + 'display-box.js',
                        paths.c_js + 'shared.js'
                    ],
                    'site/public/js/includes/home-slider.js' : [
                        'site/cwd/js/includes/home-slider.js'
                    ],
                    'site/public/js/includes/text-left.js' : [
                        'site/cwd/js/includes/text-left.js'
                    ]
                }
            }
        },
        cssmin: {
            options: {
                shorthandCompacting: true,
            },
            target: {
                files: {
                    'site/public/css/main-full.css': ['site/public/css/main.css']
                }
            }
        },
        ftpush: {
            build: {
                auth: {
                    host: 'dev.ambrosiatc.com',
                    port: 21,
                    authKey: 'key1'
                },
                src: 'site/',
                dest: 'site/',
                exclusions: ['site/public/css/','site/cwd/Sass/'],
                keep: [''],
                simple: true,
                useList: false,
                cachePath: ''
            }
        },
        watch: {
            options: {
                livereload: true
            },
            css: {
                files: [
                    paths.scss + '**',
                    paths.scss + '*.scss',
                    paths.c_js_form + '*.js',
                    paths.c_js_widgets + '*.js',
                    paths.c_js_c + '*.js',
                    paths.c_views + '**',
                    paths.c_js_form + 'sign-in.js',
                    paths.c_js_form + 'journal-entry-form.js',
                    paths.c_js_plugs + 'mg-validator.js',
                    paths.c_js_c + 'nav.js',
                    paths.c_js + 'shared.js'
                ],
                tasks: ['htmlclean',/*'sass','cssmin','uglify',*/'ftpush']
            },
        },
    });
    grunt.loadNpmTasks('grunt-htmlclean');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-reload-chrome');
    grunt.loadNpmTasks('grunt-ftpush');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    // Do the Task
    grunt.registerInitTask('default', ['htmlclean',/*'sass','cssmin','uglify',*/'ftpush','watch']);
}
