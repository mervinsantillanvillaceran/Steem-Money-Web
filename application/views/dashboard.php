<!DOCTYPE html>
<html>
<head>
	<title>Steem Money</title>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/bootstrap/css/bootswatch.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/app.css">
</head>
<body>
	<nav class="navbar navbar-steem">
	  	<div class="container">
	    	<div class="navbar-header">
		      	<a class="navbar-brand">
	    			<span><img src="<?=base_url()?>asset/images/logo.png" width="35px"></span>&nbsp;&nbsp;
		        	<span class="steem">Steem</span> <span class="money">Money</span>
		      	</a>
	    	</div>
	      	<p class="navbar-text navbar-right"><a href="https://steemit.com/@gentlemanoi" target="_blank">@gentlemanoi</a></p>
	  	</div>
	</nav>

	<div id="app">
        <div class="container">
    		<div class="row">
        		<div class="col-md-offset-2 col-md-8">
        			<br><br>
    				<div class="panel panel-success">
				  		<div class="panel-heading">
				  			C O N V E R T E R
				  			<span class="pull-right">STEEM: ${{Number(steem.price_usd).toFixed(2)}} &nbsp;&nbsp; SBD: ${{Number(sbd.price_usd).toFixed(2)}}</span>
				  		</div>	
				  		<div class="panel-body">
	    					<br>
	    					<div class="row">
								<div class="col-md-5">
									<label>From</label>
								</div>		
								<div class="col-md-7">
									<label>Value</label>
								</div>		     							
	    						<div class="col-md-5">
		    						<select class="form-control" v-model="from_currency" @change="calculate()">
		    							<option>STEEM</option>
		    							<option>SBD</option>
		    						</select>
	    						</div>
	    						<div class="col-md-7">
		    						<input type="text" name="firstname" class="form-control" required="" v-model="from_value" placeholder="Value" @keyup="calculate()">
		    					</div>
	    					</div>
	    					<div class="row">
	    						<br>
								<div class="col-md-5">
									<label>To</label>
								</div>		
								<div class="col-md-7">
									<label>Result</label>
								</div>		  
	    						<div class="col-md-5">
		    						<select class="form-control" v-model="to_currency" @change="calculate()">
		    							<option v-for="currency in currencies" :value="currency.id">{{currency.name}}</option>
		    						</select>
	    						</div>
	    						<div class="col-md-7">
		    						<input type="text" name="firstname" class="form-control" required="" v-model="to_value" placeholder="Value" disabled="">
		    					</div>
	    					</div>
	    					<br>
	    					<br>
				  		</div>
					</div>
        		</div>
    		</div>
		</div>
    </div>

	<div class="navbar-fixed-bottom steem-footer">
		<div class="container text-footer">
			<span class="steem">Copyright</span> <span class="money">@2018</span>
		</div>
	</div>
	<script type="text/javascript" src="<?=base_url()?>asset/vue/vue.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>asset/axios/axios.min.js"></script>

	<script type="text/javascript">
		var api = '<?php echo base_url();?>';                
    
	    var app = new Vue({
	        el: '#app',
	        data: {
	        	currencies: [
						        { id: 'BTC', name: 'Bitcoin' },
						        { id: 'AUD', name: 'Australian Dollar' },
						        { id: 'BRL', name: 'Brazilian Real' },
						        { id: 'GBP', name: 'British Pound' },
						        { id: 'BGN', name: 'Bulgarian Lev' },
						        { id: 'CAD', name: 'Canadian Dollar' },
						        { id: 'CNY', name: 'Chinese Yuan' },
						        { id: 'HRK', name: 'Croatian Kuna' },
						        { id: 'CZK', name: 'Czech Koruna' },
						        { id: 'DKK', name: 'Danish Krone' },
						        { id: 'EUR', name: 'Euro' },
						        { id: 'HKD', name: 'Hong Kong Dollar' },
						        { id: 'HUF', name: 'Hungarian Forint' },
						        { id: 'ISK', name: 'Icelandic Krona' },
						        { id: 'INR', name: 'Indian Rupee' },
						        { id: 'IDR', name: 'Indonesian Rupiah' },
						        { id: 'ILS', name: 'Israeli New Shekel' },
						        { id: 'JPY', name: 'Japanese Yen' },
						        { id: 'MYR', name: 'Malaysian Ringgit' },
						        { id: 'MXN', name: 'Mexican Peso' },
						        { id: 'NZD', name: 'New Zealand Dollar' },
						        { id: 'NOK', name: 'Norwegian Krone' },
						        { id: 'PHP', name: 'Philippine Peso' },
						        { id: 'PLN', name: 'Polish Zloty' },
						        { id: 'RON', name: 'Romanian Leu' },
						        { id: 'RUB', name: 'Russian Ruble' },
						        { id: 'SGD', name: 'Singapore Dollar' },
						        { id: 'ZAR', name: 'South African Rand' },
						        { id: 'KRW', name: 'South Korean Won' },
						        { id: 'CHF', name: 'Swiss Franc' },
						        { id: 'SEK', name: 'Swedish Krona' },
						        { id: 'THB', name: 'Thai Baht' },
						        { id: 'TRY', name: 'Turkish Lira' },
						        { id: 'USD', name: 'US Dollar' }
						    ],
	           	from_currency: 'STEEM',
	           	to_currency: 'BTC',
	           	from_value: 0,
	           	to_value: 0,
	           	rates:{},
	           	steem: {},
	           	sbd: {}
	        },
	        created() {
	            this.get()
	        },
	        methods: {
	            get: function() {
	            	var vm = this;
	            	axios({
						method:'get',
						url:'https://api.fixer.io/latest?base=USD',
						responseType:'json'
					}).then(function(response) {
					  	vm.rates = response.data.rates;
					});

	            	axios({
						method:'get',
						url:'https://api.coinmarketcap.com/v1/ticker/steem-dollars/',
						responseType:'json'
					}).then(function(response) {
					  	vm.sbd = response.data[0];
					});
					
	            	axios({
						method:'get',
						url:'https://api.coinmarketcap.com/v1/ticker/steem/',
						responseType:'json'
					}).then(function(response) {
					  	vm.steem = response.data[0];
					});
	            },
	            calculate: function(){
	            	var result = 0;
	            	if (this.from_currency == 'STEEM') {
		                if (this.to_currency == 'BTC') {
		                    result = this.getValue(this.steem.price_btc); 
		                }
		                else if (this.to_currency == 'USD') {
		                    result = this.getValue(this.steem.price_usd); 
		                }
		                else {
		                    result = this.getValue(this.steem.price_usd) * parseFloat(this.rates[this.to_currency]); 
		                }
		            }
		            else {
		                if (this.to_currency == 'BTC') {
		                    result = this.getValue(this.sbd.price_btc);
		                }
		                else if (this.to_currency == 'USD') {
		                    result = this.getValue(this.sbd.price_usd);
		                }
		                else {
		                    result = this.getValue(this.sbd.price_usd) * parseFloat(this.rates[this.to_currency]); 
		                }
		            }

		            if (isNaN(result)) {
		                result = '0.000';
		            }
		            else {
		                result = result.toFixed(3);
		            }

		            this.to_value = result + ' ' + this.to_currency;
	            },
	            getValue: function(val){
	            	return parseFloat(this.from_value) * parseFloat(val); 
	            }
	        }
	    })
	</script>
</body>
</html>