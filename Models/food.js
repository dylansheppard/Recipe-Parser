var mongoose = require('mongoose');
var Schema = mongoose.Schema;
var aFood = require('../components/absurdSchema.js'); 
//call via - aFood.nutrientSchema

modules.exports = mongoose.model('Food', aFood);




