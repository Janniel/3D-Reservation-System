const path = require('path')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

module.exports = {
    mode: 'development',
    entry: {
        reserve: path.resolve(__dirname, 'src/reserve.js'),
        // seatsInfo: path.resolve(__dirname, 'src/seats-info3D.js'),
        home: path.resolve(__dirname, 'src/home.js'),
        clock: path.resolve(__dirname, 'src/clock.js'),
        login: path.resolve(__dirname, 'src/login.js'),
        profile: path.resolve(__dirname, 'src/profile.js'),
        timer: path.resolve(__dirname, 'src/timer.js'),
        update_profile: path.resolve(__dirname, 'src/update_profile.js'),
        loginAdmin: path.resolve(__dirname, 'src/loginAdmin.js'),
        admin: path.resolve(__dirname, 'src/admin.js'),
        manageAdmin: path.resolve(__dirname, 'src/manageAdmin.js'),
        flatpickr: path.resolve(__dirname, 'src/flatpickr.js'),
        seats_info: path.resolve(__dirname, 'src/seats_info.js'),
        analytics: path.resolve(__dirname, 'src/analytics.js'),
        reserved: path.resolve(__dirname, 'src/reserved.js'),
        users: path.resolve(__dirname, 'src/users.js'),
        export: path.resolve(__dirname, 'src/export.js'),
        history: path.resolve(__dirname, 'src/history.js'),
        adminProfile: path.resolve(__dirname, 'src/adminProfile.js'),
        adminReviews: path.resolve(__dirname, 'src/adminReviews.js'),

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
                {
                    from: 'src/bootstrap',
                    to: 'bootstrap',
                },
                {
                    from: 'src/models/6thFloorV2.glb',
                    to: 'models',
                },
                {
                    from: 'src/models/spruit_sunrise_1k_HDR.hdr',
                    to: 'models',
                },
              ],
              
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'reserve.php',
            template: 'src/reserve.php',
            chunks: ['reserve']
        }),
        // new HtmlWebpackPlugin({
        //     inject: true,
        //     filename: 'seats-info3D.php',
        //     template: 'src/seats-info3D.php',
        //     chunks: ['seatsInfo']
        // }),
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
            filename: 'profile.php',
            template: 'src/profile.php',
            chunks: ['profile']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/timer.php',
            template: 'src/php/timer.php',
            chunks: ['timer']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'receipt.php',
            template: 'src/receipt.php',
            chunks: ['profile']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'occupy.php',
            template: 'src/occupy.php',
            chunks: ['update_profile']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'occupyProcess.php',
            template: 'src/occupyProcess.php',
            chunks: ['']
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
            chunks: ['clock']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/header.php',
            template: 'src/php/header.php',
            chunks: ['clock']
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
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/footer.php',
            template: 'src/php/footer.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/profile_tab1.php',
            template: 'src/php/profile_tab1.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/profile_tab2.php',
            template: 'src/php/profile_tab2.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/profile_tab3.php',
            template: 'src/php/profile_tab3.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toCancelReservation.php',
            template: 'src/php/toCancelReservation.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'toLogout.php',
            template: 'src/toLogout.php',
            chunks: ['']
        }),



        new HtmlWebpackPlugin({
            inject: true,
            filename: 'toRegister.php',
            template: 'src/toRegister.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'update_profile.php',
            template: 'src/update_profile.php',
            chunks: ['update_profile']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateAcc.php',
            template: 'src/php/toUpdateAcc.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateInfo.php',
            template: 'src/php/toUpdateInfo.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdatePass.php',
            template: 'src/php/toUpdatePass.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateRFID.php',
            template: 'src/php/toUpdateRFID.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toAddHistory.php',
            template: 'src/php/toAddHistory.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'get_seat_status.php',
            template: 'src/get_seat_status.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'toReserve.php',
            template: 'src/php/toReserve.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'fetchSeatInfo.php',
            template: 'src/php/fetchSeatInfo.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'fetchSeatId.php',
            template: 'src/php/fetchSeatId.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'fetchSeatStatus.php',
            template: 'src/php/fetchSeatStatus.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'get_disabled_dates.php',
            template: 'src/get_disabled_dates.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/validateReservation.php',
            template: 'src/php/validateReservation.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/maintenance.php',
            template: 'src/php/maintenance.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'survey.php',
            template: 'src/survey.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'surveyProcess.php',
            template: 'src/surveyProcess.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/extendProcess.php',
            template: 'src/php/extendProcess.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'fetchSeatInfo2.php',
            template: 'src/php/fetchSeatInfo2.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toDestroy.php',
            template: 'src/php/toDestroy.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toFix.php',
            template: 'src/php/toFix.php',
            chunks: ['']
        }),



        new HtmlWebpackPlugin({
            inject: true,
            filename: 'loginAdmin.php',
            template: 'src/loginAdmin.php',
            chunks: ['loginAdmin']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'admin.php',
            template: 'src/admin.php',
            chunks: ['admin']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/manageAdmin.php',
            template: 'src/php/manageAdmin.php',
            chunks: ['manageAdmin']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'seats-info.php',
            template: 'src/seats-info.php',
            chunks: ['seats_info']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/libraries_admin.php',
            template: 'src/php/libraries_admin.php',
            chunks: ['flatpickr']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/analytics.php',
            template: 'src/php/analytics.php',
            chunks: ['analytics']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/reserved.php',
            template: 'src/php/reserved.php',
            chunks: ['reserved']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toArchive.php',
            template: 'src/php/toArchive.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toDelete.php',
            template: 'src/php/toDelete.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/get_monthly_data.php',
            template: 'src/php/get_monthly_data.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toRestore.php',
            template: 'src/php/toRestore.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toRestoreUser.php',
            template: 'src/php/toRestoreUser.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/user-list.php',
            template: 'src/php/user-list.php',
            chunks: ['users','export','history']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/history.php',
            template: 'src/php/history.php',
            chunks: ['users','export','history']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toArchiveHistory.php',
            template: 'src/php/toArchiveHistory.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toArchiveUser.php',
            template: 'src/php/toArchiveUser.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toRestoreHistory.php',
            template: 'src/php/toRestoreHistory.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toDeleteHistory.php',
            template: 'src/php/toDeleteHistory.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toDeleteUser.php',
            template: 'src/php/toDeleteUser.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/adminProfile.php',
            template: 'src/php/adminProfile.php',
            chunks: ['adminProfile']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/adminReviews.php',
            template: 'src/php/adminReviews.php',
            chunks: ['adminReviews']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateAdmin.php',
            template: 'src/php/toUpdateAdmin.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateAdminPass.php',
            template: 'src/php/toUpdateAdminPass.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateAdminSA.php',
            template: 'src/php/toUpdateAdminSA.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/toUpdateAdminUname.php',
            template: 'src/php/toUpdateAdminUname.php',
            chunks: ['']
        }),
        new HtmlWebpackPlugin({
            inject: true,
            filename: 'php/settings.php',
            template: 'src/php/settings.php',
            chunks: ['analytics']
        }),
  
    ]
}