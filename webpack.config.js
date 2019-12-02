const path = require('path')
const HTMLWebpackPlugin = require('html-webpack-plugin')

module.exports = {
	mode: 'development',
	entry: './src/index.jsx',
	output: {
		filename: 'main.js',
		path: path.resolve(__dirname, 'build')
	},
	devServer: {
		contentBase: './dist',
		port: 9000,
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader'
				}
			},
			{
				test: /\.css$/,
				use: ['style-loader', 'css-loader']
			},
			{
				test: /\.s[ac]ss$/,
				use: [
					'style-loader',
					{
						loader: 'css-loader',
						options: {
							modules: {
								localIdentName: '[name]__[local]--[hash:base64:5]',
							}
						}
					},
					{
						loader: 'sass-loader',
						options: {
						  sassOptions: {
							 indentWidth: 4,
							 includePaths: [path.resolve(__dirname, "./src/styles")],
						  },
						},
					},
				]
			},
			{
				test: /\.(png|svg|jpg|gif)$/,
				loader: 'file-loader',
				options: {
					outputPath: 'images',
				},
			}
		]
	},
	plugins: [],
	resolve: {
		modules: [path.resolve(__dirname, 'src'), 'node_modules'],
		extensions: ['.js', '.jsx', '.css', '.scss']
	}
}