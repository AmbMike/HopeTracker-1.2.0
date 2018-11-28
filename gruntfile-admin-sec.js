/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 12:58 PM
 * FOR ADMIN SECTION
 */

module.exports = function(grunt){
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            dist: {
                options:{
                    style: 'compressed',

                },
                files: [{
                    expand: true,
                    cwd: 'HopeAdmin/site/cwd/sass',
                    src: [
                        'general.scss'
                    ],
                    dest: 'HopeAdmin/site/public/css',
                    ext: '.css'
                }]
            }
        },

        htmlclean: {
            deploy: {
                expand: true,
                cwd: 'HopeAdmin/site/cwd/views',
                src: '**/*.php',
                //src: '**/admin/*.php',

                dest: 'HopeAdmin/site/public/views'
            }
        },


        uglify: {
            options: {
                beautify: true
            },
            my_target: {
                files: {
                    'HopeAdmin/site/public/js/main.js': [
                        'HopeAdmin/site/cwd/js/validation.js',
                        'HopeAdmin/site/cwd/js/main.js'

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
                    'HopeAdmin/site/public/css/main.css': [

                        'HopeAdmin/site/public/css/general.css'
                    ]
                }
            }
        },

        ftpush: {
            build: {
                auth: {
                    host: 'hopetracker.com',
                    port: 21,
                    authKey: 'key1'
                },
                src: 'HopeAdmin/site/',
                dest: 'HopeAdmin/site/',
                exclusions: [],
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
                    'HopeAdmin/site/cwd/**',
                ],
                tasks: ['htmlclean','sass','cssmin','uglify'/*,'ftpush'*/]
            }
        }
    });
    grunt.loadNpmTasks('grunt-htmlclean');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-reload-chrome');
    grunt.loadNpmTasks('grunt-contrib-cssmin')
    grunt.loadNpmTasks('grunt-ftpush');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Do the Task
    grunt.registerInitTask('default', ['htmlclean','sass','cssmin','uglify'/*,'ftpush'*/,'watch']);
}
