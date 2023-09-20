const path = require('path');
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    main: './src/index.js', // Change the entry file to .js
  },
  resolve: {
    extensions: ['.js', '.jsx', '.scss', '.css'], // Remove TypeScript extensions
    alias: {
      '@src': path.resolve(__dirname, 'src/'),
    //   '@assets': path.resolve(__dirname, 'src/assets/'),
    //   '@components': path.resolve(__dirname, 'src/components'),
    //   '@routes': path.resolve(__dirname, 'src/routes'),
    //   '@layouts': path.resolve(__dirname, 'src/layouts'),
    //   '@pages': path.resolve(__dirname, 'src/pages'),
    //   '@hooks': path.resolve(__dirname, 'src/hooks'),
    },
  },
  output: {
    path: path.join(__dirname, './dist'),
    filename: 'app.min.js',
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/, // Match both .js and .jsx files
        exclude: /node_modules/,
        use: 'babel-loader', // Add babel-loader for JavaScript
      },
      {
        test: /\.js$/, // Change the test to match .js files
        exclude: /node_modules/,
        use: 'babel-loader', // Add babel-loader for JavaScript
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader',
        ],
      },
      {
        test: /\.(ttf|woff|woff2)$/,
        exclude: /node_modules/,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[name][ext]',
        },
      },
      {
        test: /\.(jpg|png|svg|gif)$/,
        type: 'asset/resource',
      },
    ],
  },
  devServer: {
    historyApiFallback: true,
  },
  plugins: [ 
    new webpack.DefinePlugin({
        'process.env.NODE_ENV': JSON.stringify('production'),
    }),
    new webpack.HotModuleReplacementPlugin(),
    new HtmlWebpackPlugin({
      template: './public/index.html',
    //   favicon: './src/assets/logo.svg',
    }),
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[id].css',
    })
  ],
};