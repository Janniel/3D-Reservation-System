const path = require('path')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

module.exports = {
    mode: 'development',
    entry: {
        reserve: path.resolve(__dirname, 'src/reserve.js'),
        home: path.resolve(__dirname, 'src/home.js'),
        clock: path.resolve(__dirname, 'src/clock.js'),
        login: path.resolve(__dirname, 'src/login.js'),
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name][contenthash].js',
        clean: true,
        assetModuleFilename: '[name][ext]'
    },
    optimization: {
        splitChunks: {
            chunks: "all",
        },
    },

    devtool: 'source-map',
    devServer: {
        static: {
            directory: path.resolve(__dirname, 'dist')
        },
        open: true,
        hot: true,
        compress: true,
        historyApiFallback: true,
        
    },
    
    module: {
        rules: [
            {
                test:/\.css$/,
                use: [
                    'style-loader',
                    'css-loader'
                ]
            },
            {
                test: /\.(glb|gltf|bin)$/i,
                type: 'asset/resource',
                use: {
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'models'
                    }
                }
                
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            // {
            //     test: /\.(png|svg|jpg|jpeg|gif)$/i,
            //     type: 'asset/resource',
            //     use: {
            //         loader: 'file-loader',
            //         options: {
            //                 name: '[name].[ext]',
            //                 outputPath: 'img'
            //         }
            //     },
            // },
        ]
    },
    plugins: [
        new CopyWebpackPlugin({
            patterns: [
                {
                  from: 'src/img',
                  to: 'img',
                },
              ],
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'reserve.php',
            template: 'src/reserve.php',
            chunks: ['reserve']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'index.php',
            template: 'src/index.php',
            chunks: ['home','clock']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'login.php',
            template: 'src/login.php',
            chunks: ['login']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/connect.php',
            template: 'src/php/connect.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/session.php',
            template: 'src/php/session.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/get_server_time.php',
            template: 'src/php/get_server_time.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/header_notLogged.php',
            template: 'src/php/header_notLogged.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/header.php',
            template: 'src/php/header.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/occupancy_timer.php',
            template: 'src/php/occupancy_timer.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/check_user_id.php',
            template: 'src/php/check_user_id.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/login_modal.php',
            template: 'src/php/login_modal.php',
            chunks: ['']
        }),
    ]
}