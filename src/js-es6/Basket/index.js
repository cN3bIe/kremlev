'use strict';

import LS from '../LS';
import Card from './Card';

export default class Basker {
	constructor( init ){
		if( typeof(init) === 'function' ) this.init( init );
	}
	pI( val ){
		return parseInt(val) || 0;
	}
	clean( ){
		this.card = [];
		this.total = 0;
		this.count = 0;
		this.timer = 0;
	}
	init( callback ){
		console.log('Basket init');
		this.clean();
		if( LS.get('Basket') ){
			Object.assign( this, LS.get('Basket') );
			this.card.forEach(	(el,index,arr) => arr[index] = new Card( el ) );
		}else this.change();
		if( LS.get('timer') ) this.timer = LS.get('timer');
		if( callback ) callback.call( this, this);
	}
	nobj(
		obj,
		title,
		url,
		img,
		count,
		price,
		oldprice,
		specprice
	){
		if(obj instanceof Object) return ({
			id: obj.id.replace(/(\W|\s)+/g,'') || 0,
			title: obj.title || 'Без имени',
			url: obj.url || '',
			img: obj.img.replace(/url\(\"?|\"?\)/gi,'') || '',
			count: this.pI(obj.count),
			price: this.pI(obj.price),
			oldprice: this.pI(obj.oldprice),
			specprice: this.pI(obj.specprice)
		});
		else return ({
			id: (''+obj).replace(/(\W|\s)+/g,'') || 0,
			title: title || 'Без имени',
			url: url || '',
			img: img.replace(/url\(\"?|\"?\)/gi,'') || '',
			count: this.pI(count),
			price: this.pI(price),
			oldprice: this.pI(oldprice),
			specprice: this.pI(specprice)
		});
	}
	setTimer( value ){ return LS.set('timer', this.timer = value ); }
	getTimer( ){ return this.timer; }
	getCountCard( ){ return this.card.length; }
	getCount( ){ return this.count; }
	getTotal( ){ return this.total; }
	getOldTotal( ){ return this.oldtotal; }
	getSaleTotal( ){
		return this.card.reduce( ( sale_sum, el ) => ( sale_sum + el.getOldTotal() - el.getTotal() ),0 );
	}
	getCard( id_card ){
		if( id_card )
			return this.card.filter( el => el.id === (''+id_card).replace(/(\W|\s)+/g,'') ).shift();
		else
			return this.card;
	}
	hasCard( id_card){
		id_card = (''+id_card).replace(/(\W|\s)+/g,'');
		return this.card.some( el => el.id === id_card );
	}
	checked( arr ){
		if( Array.isArray(arr) && arr.length && Array.isArray(self.card) && self.card.length){
			self.card.forEach(function(el){
				if( !arr.some(function(id_card){ return el.id === id_card;}) ) self.removeCard( el.id );
			});
		}else self.card = [];
	}
	change( ){
		LS.set('Basket',{
			count: this.changeCount(),
			total: this.changeTotal(),
			oldtotal: this.changeOldTotal(),
			card: this.card
		});
	}
	changeCount( ){
		switch( this.card.length ){
			case 0:
				return 0;
				break;
			case 1:
				return this.count = this.card[0].count;
				break;
			default:
				return this.count = this.card.reduce( ( sum, el ) => sum + el.count, 0 );
				break;
		}
	}
	changeTotal( ){
		switch( this.card.length ){
			case 0:
				return this.total = 0;
				break;
			case 1:
				return this.total = this.card[0].getTotal();
				break;
			default:
				return this.total = this.card.reduce( ( sum, el ) => sum + el.getTotal( self.timer ),0 );
				break;
		}
	}
	changeOldTotal( ){
		switch( this.card.length ){
			case 0:
				return this.oldtotal = 0;
				break;
			case 1:
				return this.oldtotal = this.card[0].getOldTotal();
				break;
			default:
				return this.oldtotal = this.card.reduce( ( sum, el ) => sum + el.getOldTotal(), 0 );
				break;
		}
	}
	addCard( ){
		var obj = this.nobj.apply(this,arguments);
		if( this.card.length && this.card.some( function(e){ return e.id === obj.id} ) ){
			this.changeCard(obj.id, obj.count);
			return !1;
		}
		this.card.push(new Card(obj));
		this.change();
		return this.card.slice(-1);
	}
	changeCard( _id,count ){
		if( !_id && !count) return !1;
		_id = (''+_id).replace(/(\W|\s)+/g,'');
		count = parseInt( count );
		var ret;
		this.card.forEach(function(el,ind,arr){
			if( el.id === _id ) (ret = arr[ind]).count = count;
		});
		this.change();
		return ret;
	}
	removeCard(id_card ){
		this.card = this.card.filter( (el,index,arr) => el.id !== (''+id_card).replace(/(\W|\s)+/g,'') );
		this.change();
	}
	clear( ){
		// LS.clear();
		this.clean();
		this.change();
	}
}