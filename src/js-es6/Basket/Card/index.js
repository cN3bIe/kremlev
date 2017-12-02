export default class Card {
	constructor( obj ){
		Object.assign(this, obj);
	}
	getTotal( timestamp = 0 ){
		if( timestamp && timestamp < Date.now() ) return ( this.price = this.specprice || this.price ) * this.count;
		else return this.price * this.count;
	}
	getOldTotal(){
		if( this.oldprice ) return this.oldprice * this.count;
		else return this.price * this.count;
	}
}