'use strict';

import LS from '../LS';

export default class Bookmark {
	constructor( init ){
		if( typeof(init) === 'function' ) this.init( init );
	}
	clean(){
		this.card = [];
	}
	init(callback){
		console.log('Bookmark init');
		this.clean();
		if(LS.get('Bookmark')){
			Object.assign( this , LS.get('Bookmark') );
		}else this.change();
		if( callback ) callback.call( this,this );
	}
	checked(arr){
		if( Array.isArray(arr) && arr.length && Array.isArray( this.card ) && this.card.length ){
			this.card.forEach(function(id){
				if( !arr.some(function(id_card){ return id === id_card;}) ) _.removeCard( id );
			});
		}else this.card = [];
	}
	getCard( id_card ){
		if(id_card) return this.card.filter( id => id === (''+id_card).replace(/(\W|\s)+/g,'') ).shift();
		else return this.card;
	}
	hasCard(id_card){
		id_card = ('' + id_card).replace(/(\W|\s)+/g,'');
		if( !id_card ) throw 'Empty variables';
		return this.card.some( function( id ){ return id === id_card; });
	}
	getCountCard(){return this.card.length;}
	change( ){
		LS.set( 'Bookmark',{ card: this.card } );
	}
	addCard( _id ) {
		_id = (''+_id).replace(/(\W|\s)+/g,'');
		if( this.card.length && this.card.some( id => id === _id ) ) return this.removeCard( _id );
		this.card.push( _id );
		this.change();
		return this.card.slice( -1 );
	}
	removeCard( _id ){
		_id = (''+_id).replace(/(\W|\s)+/g,'');
		this.card = this.card.filter( id => id !== _id );
		this.change();
	}
	clear(){
		LS.clear();
		this.clean();
		this.change();
	};
};
