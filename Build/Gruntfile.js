module.exports = function(grunt) {

    /**
     * Project configuration.
     */
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        paths: {
            root: '../',
            src: '<%= paths.root %>src/',
            less: '<%= paths.src %>resources/assets/less/',
            css: '<%= paths.src %>public/css/',
            fonts: '<%= paths.src %>public/fonts/',
            img: '<%= paths.src %>public/images/',
            js_src: '<%= paths.src %>resources/assets/js/',
            js: '<%= paths.src %>public/js/',
            node_modules: '<%= paths.src %>node_modules/'
        },
        banner: '/*!\n' +
        ' * Trve Shop v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
        ' * Copyright 2018-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
        ' * Licensed under the <%= pkg.license %> license\n' +
        ' * ' +
        ' * Created as a university project.' +
        ' */\n',
        uglify: {
            all: {
                options: {
                    banner: '<%= banner %>',
                    mangle: true,
                    compress: true,
                    beautify: false
                },
                files: {
                    "<%= paths.js %>app.js": [
                        "<%= paths.node_modules %>jquery/dist/jquery.min.js",
                        "<%= paths.node_modules %>feather-icons/dist/feather.min.js",
                        "<%= paths.node_modules %>simplemde/dist/simplemde.min.js",
                        "<%= paths.js_src %>app.js"
                    ],
                }
            }
        },
        less: {
            backend: {
                options: {
                    plugins: [
                        new (require('less-plugin-lists')),
                        new (require('less-plugin-functions'))
                    ]
                },
                src: '<%= paths.less %>backend.less',
                dest: '<%= paths.css %>backend.css'
            },
            frontend: {
                options: {
                    plugins: [
                        new (require('less-plugin-lists')),
                        new (require('less-plugin-functions'))
                    ]
                },
                src: '<%= paths.less %>frontend.less',
                dest: '<%= paths.css %>frontend.css'
            }
        },
        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer')({
                        browsers: [
                            'Last 2 versions',
                            'Firefox ESR',
                            'IE 9'
                        ]
                    })
                ]
            },
            backend: {
                src: '<%= paths.css %>backend.css'
            },
            frontend: {
                src: '<%= paths.css %>frontend.css'
            }
        },
        cssmin: {
            options: {
                keepSpecialComments: '*',
                advanced: false
            },
            backend: {
                src: '<%= paths.css %>backend.css',
                dest: '<%= paths.css %>backend.min.css'
            },
            frontend: {
                src: '<%= paths.css %>frontend.css',
                dest: '<%= paths.css %>frontend.min.css'
            }
        },
        image: {
            extension: {
                files: [{
                    expand: true,
                    cwd: '<%= paths.resources %>',
                    src: [
                        '**/*.{png,jpg,gif,svg}'
                    ],
                    dest: '<%= paths.resources %>'
                }]
            }
        },
        watch: {
            options: {
                livereload: true
            },
            less: {
                files: '<%= paths.less %>**/*.less',
                tasks: ['less', 'postcss', 'cssmin']
            },
            javascript: {
                files: '<%= paths.js_src %>**/*.js',
                tasks: ['js']
            }
        }
    });

    /**
     * Register tasks
     */
    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-image');

    /**
     * Grunt update task
     */
    grunt.registerTask('css', ['less', 'postcss', 'cssmin']);
    grunt.registerTask('js', ['uglify']);
    grunt.registerTask('build', ['js', 'css', 'image']);
    grunt.registerTask('default', ['build']);

};
