/*
UvumiTools ColorSphere v1.0.0 http://uvumi.com/tools/sphere.html

Copyright (c) 2008 Uvumi LLC

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/
var UvumiSphere=new Class({Implements:[Options,Events],options:{defaultColor:'#ffffff',specterImage:'/image/colorPicker/circle.jpg',cursorImage:'/image/colorPicker/miniCurr.gif',buttonText:'pick',onChange:$empty,onComplete:$empty},initialize:function(a,b){this.setOptions(b);var c=new Asset.images([this.options.specterImage,this.options.cursorImage]);window.addEvent('domready',this.build.bind(this,a))},build:function(c){$$(c).each(function(a){if(a.get('tag')=='input'){a=a.clone().set('type','hidden').set('id',a.get('id')).replaces(a);var b=new Element('button',{'class':'colorSphereButton','html':this.options.buttonText,'type':'button','events':{'click':this.toggle.bindWithEvent(this)}}).inject(a,'after')}},this);this.container=new Element('div',{'class':'colorSphere','styles':{'display':'none','position':'absolute','z-index':100}}).inject(document.body);this.topbar=new Element('div',{'class':'topbar'}).inject(this.container);this.closeButton=new Element('div',{'class':'closeButton','html':'X','events':{'click':this.toggle.bindWithEvent(this),'mousedown':function(e){new Event(e).stopPropagation()}},'styles':{'float':'right'}}).inject(this.topbar);this.hex=new Element('input',{'class':'hexa','value':this.options.defaultColor,'type':'text','size':7,'name':'color','events':{'keyup':this.setColor.bind(this),'mousedown':function(e){new Event(e).stopPropagation()}}}).inject(this.topbar);this.spectrum=new Element('div',{'class':'spectrum','events':{'mousedown':this.colorDown.bindWithEvent(this)},'styles':{'padding':0,'position':'relative'}}).inject(this.container);this.selector=new Element('div',{'class':'selector','styles':{'margin':0,'padding':0,'line-height':0,'font-size':0,'position':'absolute','z-index':101}}).inject(this.spectrum);this.drag=this.selector.makeDraggable({snap:1,onDrag:this.calculateColor.bind(this),onComplete:function(){this.fireEvent('onComplete',[this.activeInput,this.activeInput.get('value')])}.bind(this)});this.container.makeDraggable({handle:this.topbar,onComplete:function(){this.spectrumCoords=this.spectrum.getPosition()}.bind(this)});this.showing=false;this.activeInput=false;this.offset=(Browser.Engine.trident?6:4)},toggle:function(e){var a=new Event(e).stop();if($(a.target)==this.closeButton||!this.activeInput||this.activeInput.getNext()==$(a.target)){this.showing=!this.showing}if(this.showing){var b=$(e.target).getCoordinates();this.container.setStyles({'top':b.bottom+5,'left':b.left,'display':'block'});this.spectrumCoords=this.spectrum.getPosition();this.W=this.spectrum.getSize().x;this.W2=this.W/2;this.W3=this.W2/2;this.activeInput=$(a.target).getPrevious();var c=this.activeInput.get('value')||this.options.defaultColor;this.setColor(c)}else{this.container.setStyle('display','none');this.activeInput=false}},colorDown:function(e){this.selector.setStyles({'top':e.page.y-this.spectrumCoords.y-this.offset,'left':e.page.x-this.spectrumCoords.x-this.offset});this.calculateColor();this.drag.start(e)},calculateColor:function(){v=this.selector.getPosition(this.spectrum);var x=v.x-this.W2+4;var y=this.W-v.y-4-this.W2;var a=Math.sqrt(Math.pow(x,2)+Math.pow(y,2));var b=Math.atan2(x,y)/(Math.PI*2);var c=[b>0?(b*360):((b*360)+360),a<this.W3?(a/this.W3)*100:100,a>=this.W3?Math.max(0,1-((a-this.W3)/(this.W2-this.W3)))*100:100];var d=c.hsbToRgb().rgbToHex();$$(this.activeInput,this.hex).set('value',d);if(c[2]<1){this.moveCursor(c)}this.fireEvent('onChange',[this.activeInput,d])},moveCursor:function(a){var b=(a[0]/360)*(Math.PI*2);var c=(a[1]+(100-a[2]))/100*(this.W2/2);this.selector.setStyles({left:Math.round(Math.abs(Math.round(Math.sin(b)*c)+this.W2))-4,top:Math.round(Math.abs(Math.round(Math.cos(b)*c)-this.W2))-4})},setColor:function(a){if(!this.showing){return}if($type(a)!='string'){var a=this.hex.get('value')}else{this.hex.set('value',a)}var b=a.hexToRgb(true);if(!$chk(b)){return}this.activeInput.set('value',a);b=b.rgbToHsb();this.moveCursor(b)}});

//temporary fix for opera until the mootools is fixed
Element.implement({getPosition:function(a){if((/^(?:body|html)$/i).test(this.tagName))return{x:0,y:0};var b=this.getOffsets(),scroll=this.getScrolls();var c={x:b.x-scroll.x,y:b.y-scroll.y};var d=(a&&(a=$(a)))?a.getPosition():{x:0,y:0};if(Browser.Engine.presto925){var c={x:b.x,y:b.y}}return{x:c.x-d.x,y:c.y-d.y}}});