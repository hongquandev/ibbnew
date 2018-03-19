/*  Tipped 2.0.2 [demo] - 23-08-2011
 *  (c) 2010-2011 Nick Stakenburg - http://www.nickstakenburg.com
 *
 *  Tipped is licensed under the terms of the Tipped License:
 *  http://projects.nickstakenburg.com/tipped/license
 *
 *  More information on this project:
 *  http://projects.nickstakenburg.com/tipped
 */

var Tipped = { version: '2.0.2' };

Tipped.Skins = {
  // base skin, don't modify! (create custom skins in a seperate file)
  'base': {
    afterUpdate: false,
    ajax: {
      cache: true,
      type: 'get'
    },
    background: {
      color: '#f2f2f2',
      opacity: 1
    },
    border: {
      size: 1,
      color: '#000',
      opacity: 1
    },
    closeButtonSkin: 'default',
    containment: {
      selector: 'viewport'
    },
    fadeDuration: 160,
    showDelay: 50,
    hideDelay: 0,
    radius: {
      size: 3,
      position: 'background'
    },
    hideAfter: false,
    hideOn: {
      element: 'self',
      event: 'mouseleave'
    },
    hideOnClickOutside: false,
    hook: 'topleft',
    offset: {
      x: 0, y: 0,
      mouse: { x: -12, y: -12 } // only defined in the base class
    },
    onHide: false,
    onShow: false,
    shadow: {
      blur: 2,
      color: '#000',
      offset: { x: 0, y: 0 },
      opacity: .15
    },
    showOn: 'mousemove',
    spinner: true,
    stem: {
      height: 6,
      width: 11,
      offset: { x: 5, y: 5 },
      spacing: 2
    },
    target: 'self'
  },
  
  // Every other skin inherits from this one
  'reset': {
    ajax: false,
    closeButton: false,
    hideOn: [{
      element: 'self',
      event: 'mouseleave'
    }, {
      element: 'tooltip',
      event: 'mouseleave'
    }],
    hook: 'topmiddle',
    stem: true
  },

  // Custom skins start here
  'black': {
     background: { color: '#232323', opacity: .9 },
     border: { size: 1, color: "#232323" },
     spinner: { color: '#fff' }
  },

  'cloud': {
    border: {
      size: 1,
      color: [
        { position: 0, color: '#bec6d5'},
        { position: 1, color: '#b1c2e3' }
      ]
    },
    closeButtonSkin: 'light',
    background: {
      color: [
        { position: 0, color: '#f6fbfd'},
        { position: 0.1, color: '#fff' },
        { position: .48, color: '#fff'},
        { position: .5, color: '#fefffe'},
        { position: .52, color: '#f7fbf9'},
        { position: .8, color: '#edeff0' },
        { position: 1, color: '#e2edf4' }
      ]
    },
    shadow: { opacity: .1 }
  },

  'dark': {
    border: { size: 1, color: '#1f1f1f', opacity: .95 },
    background: {
      color: [
        { position: .0, color: '#686766' },
        { position: .48, color: '#3a3939' },
        { position: .52, color: '#2e2d2d' },
        { position: .54, color: '#2c2b2b' },
        { position: 0.95, color: '#222' },
        { position: 1, color: '#202020' }
      ],
      opacity: .9
    },
    radius: { size: 4 },
    shadow: { offset: { x: 0, y: 1 } },
    spinner: { color: '#ffffff' }
  },

  'facebook': {
    background: { color: '#282828' },
    border: 0,
    radius: 0,
    stem: {
      width: 7,
      height: 4,
      offset: { x: 6, y: 6 }
    },
    shadow: false,
    fadeDuration: 0
  },

  'lavender': {
    background: {
      color: [
        { position: .0, color: '#b2b6c5' },
        { position: .5, color: '#9da2b4' },
        { position: 1, color: '#7f85a0' }
      ]
    },
    border: {
      color: [
        { position: 0, color: '#a2a9be' },
        { position: 1, color: '#6b7290' }
      ],
      size: 1
    },
    radius: 1,
    shadow: { opacity: .1 }
  },

  'light': {
    border: { size: 0, color: '#afafaf' },
    background: {
      color: [
        { position: 0, color: '#fefefe' },
        { position: 1, color: '#f7f7f7' }
      ]
    },
    closeButtonSkin: 'light',
    radius: 1,
    stem: {
      height: 7,
      width: 13,
      offset: { x: 7, y: 7 }
    },
    shadow: { opacity: .32, blur: 2 }
  },

  'lime': {
    border: {
      size: 1,
      color: [
        { position: 0,   color: '#5a785f' },
        { position: .05, color: '#0c7908' },
        { position: 1, color: '#587d3c' }
      ]
    },
    background: {
      color: [
        { position: 0,   color: '#a5e07f' },
        { position: .02, color: '#cef8be' },
        { position: .09, color: '#7bc83f' },
        { position: .35, color: '#77d228' },
        { position: .65, color: '#85d219' },
        { position: .8,  color: '#abe041' },
        { position: 1,   color: '#c4f087' }
      ]
    }
  },

  'liquid' : {
    border: {
      size: 1,
      color: [
        { position: 0, color: '#454545' },
        { position: 1, color: '#101010' }
      ]
    },
    background: {
      color: [
        { position: 0, color: '#515562'},
        { position: .3, color: '#252e43'},
        { position: .48, color: '#111c34'},
        { position: .52, color: '#161e32'},
        { position: .54, color: '#0c162e'},
        { position: 1, color: '#010c28'}
      ],
      opacity: .8
    },
    radius: { size: 4 },
    shadow: { offset: { x: 0, y: 1 } },
    spinner: { color: '#ffffff' }
  },

  'blue': {
    border: {
      color: [
        { position: 0, color: '#113d71'},
        { position: 1, color: '#1e5290' }
      ]
    },
    background: {
      color: [
        { position: 0, color: '#3a7ab8'},
        { position: .48, color: '#346daa'},
        { position: .52, color: '#326aa6'},
        { position: 1, color: '#2d609b' }
      ]
    },
    spinner: { color: '#f2f6f9' },
    shadow: { opacity: .2 }
  },

  'salmon' : {
    background: {
      color: [
        { position: 0, color: '#fbd0b7' },
        { position: .5, color: '#fab993' },
        { position: 1, color: '#f8b38b' }
      ]
    },
    border: {
      color: [
        { position: 0, color: '#eda67b' },
        { position: 1, color: '#df946f' }
      ],
      size: 1
    },
    radius: 1,
    shadow: { opacity: .1 }
  },

  'yellow': {
    border: { size: 1, color: '#f7c735' },
    background: '#ffffaa',
    radius: 1,
    shadow: { opacity: .1 }
  }
};

Tipped.Skins.CloseButtons = {
  'base': {
    diameter: 17,
    border: 2,
    x: { diameter: 10, size: 2, opacity: 1 },
    states: {
      'default': {
        background: {
          color: [
            { position: 0, color: '#1a1a1a' },
            { position: 0.46, color: '#171717' },
            { position: 0.53, color: '#121212' },
            { position: 0.54, color: '#101010' },
            { position: 1, color: '#000' }
          ],
          opacity: 1
        },
        x: { color: '#fafafa', opacity: 1 },
        border: { color: '#fff', opacity: 1 }
      },
      'hover': {
        background: {
          color: '#333',
          opacity: 1
        },
        x: { color: '#e6e6e6', opacity: 1 },
        border: { color: '#fff', opacity: 1 }
      }
    },
    shadow: {
      blur: 2,
      color: '#000',
      offset: { x: 0, y: 0 },
      opacity: .3
    }
  },

  'reset': {},

  'default': {},

  'light': {
    diameter: 17,
    border: 2,
    x: { diameter: 10, size: 2, opacity: 1 },
    states: {
      'default': {
        background: {
          color: [
            { position: 0, color: '#797979' },
            { position: 0.48, color: '#717171' },
            { position: 0.52, color: '#666' },
            { position: 1, color: '#666' }
          ],
          opacity: 1
        },
        x: { color: '#fff', opacity: .95 },
        border: { color: '#676767', opacity: 1 }
      },
      'hover': {
        background: {
          color: [
            { position: 0, color: '#868686' },
            { position: 0.48, color: '#7f7f7f' },
            { position: 0.52, color: '#757575' },
            { position: 1, color: '#757575' }
          ],
          opacity: 1
        },
        x: { color: '#fff', opacity: 1 },
        border: { color: '#767676', opacity: 1 }
      }
    }
  }
};

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(B(a){B b(a,b){I c=[a,b];J c.E=a,c.F=b,c}B c(a){A.Q=a}B d(a){I b={},c;1z(c 5u a)b[c]=a[c]+"24";J b}B e(a){J a*2e/K.2w}B f(a){J a*K.2w/2e}B g(b){b&&(A.Q=b,t.1f(b),b=A.1J(),A.G=a.U({},b.G),A.1U=1,A.Y={},t.2H(A),A.1t=A.G.W.1b,A.73=A.G.T&&A.1t,A.1m())}B h(b,c,d){(A.Q=b)&&c&&(A.G=a.U({2x:3,1d:{x:0,y:0},1c:"#3R",1j:.5,2f:1},d||{}),A.1U=A.G.2f,A.Y={},u.2H(A),A.1m())}B i(b,c){P(A.Q=b)A.G=a.U({2x:5,1d:{x:0,y:0},1c:"#3R",1j:.5,2f:1},c||{}),A.1U=A.G.2f,v.2H(A),A.1m()}B j(b,c){1z(I d 5u c)c[d]&&c[d].34&&c[d].34===4B?(b[d]=a.U({},b[d])||{},j(b[d],c[d])):b[d]=c[d];J b}B k(b,c,d){P(A.Q=b){w.1f(A.Q),w.2H(A),a.11(c)=="74"?(d=c,c=1g):d=d||{},A.G=w.5v(d),d=b.5w("4C");P(!c){I e=b.5w("35-5x");e?c=e:d&&(c=d)}d&&(a(b).35("4D",d),b.75("4C","")),A.2P=c,A.1O=A.G.1O||+w.G.3S,A.Y={2I:{D:1,H:1},4E:[],2J:[],1V:{3T:!1,25:!1,1A:!1,36:!1,1m:!1,3U:!1,4F:!1}},b=A.G.1h,A.1h=b=="2m"?"2m":b=="3V"||!b?A.Q:b&&19.76(b)||A.Q,A.5y(),A.5z()}}I l=5A.37.77,m={5B:B(b,c){J B(){I d=[a.1k(b,A)].5C(l.2Q(3W));J c.4G(A,d)}},"15":{},5D:B(a,b){1z(I c=0,d=a.1p;c<d;c++)b(a[c])},17:B(a,b,c){I d=0;4H{A.5D(a,B(a){b.2Q(c,a,d++)})}4I(e){P(e!=m["15"])78 e}},3X:B(a,b,c){I d=!1;J m.17(a||[],B(a,e){P(d|=b.2Q(c,a,e))J m["15"]}),!!d},5E:B(a,b){I c=!1;J m.3X(a||[],B(a){P(c=a===b)J!0}),c},4J:B(a,b,c){I d=[];J m.17(a||[],B(a,e){b.2Q(c,a,e)&&(d[d.1p]=a)}),d},3o:B(a){I b=l.2Q(3W,1);J m.4J(a,B(a){J!m.5E(b,a)})},2n:B(a){J a&&a.79==1},4K:B(a,b){I c=l.2Q(3W,2);J 7a(B(){J a.4G(a,c)},b)},4L:B(a){J m.4K.4G(A,[a,1].5C(l.2Q(3W,1)))},3Y:B(a){J{x:a.5F,y:a.7b}},4M:B(b,c){I d=b.1h;J c?a(d).4N(c)[0]:d},Q:{3Z:B(a){I c=0,d=0;7c c+=a.40||0,d+=a.41||0,a=a.42;7d(a);J b(d,c)},43:B(c){I d=a(c).1d(),c=m.Q.3Z(c),e=a(1q).40(),f=a(1q).41();J d.E+=c.E-f,d.F+=c.F-e,b(d.E,d.F)}}},n=B(a){B b(b){J(b=5G(b+"([\\\\d.]+)").7e(a))?7f(b[1]):!0}J{5H:!!1q.7g&&a.2K("44")===-1&&b("7h "),44:a.2K("44")>-1&&b("44/"),7i:a.2K("5I/")>-1&&b("5I/"),5J:a.2K("5J")>-1&&a.2K("7j")===-1&&b("7k:"),7l:!!a.2R(/7m.*7n.*7o/),4O:a.2K("4O")>-1&&b("4O/")}}(7p.7q),o={2S:{2T:{46:"2.7r",47:1q.2T&&2T.7s},3p:{46:"1.6",47:1q.3p&&3p.7t.7u}},4P:B(){B a(a){I b=a.5K(/5L.*|\\./g,""),b=26(b+(K.48(10,4-b.1p)+"").7v(1));J a.2K("5L")>-1?b-1:b}J B(b){P(!A.2S[b].47||a(A.2S[b].47)<a(A.2S[b].46)&&!A.2S[b].5M)A.2S[b].5M=!0,5N("1B 5O "+b+" >= "+A.2S[b].46)}}()};a.U(1B,B(){I b=B(){I a=19.1r("2L");J!!a.2U&&!!a.2U("2d")}(),d;4H{d=!!19.5P("7w")}4I(e){d=!1}J{38:{2L:b,4Q:d,49:B(){I b=!1;J a.17(["7x","7y","7z"],B(a,c){4H{19.5P(c),b=!0}4I(d){}}),b}()},5Q:B(){P(!A.38.2L&&!1q.1W)P(n.5H)5N("1B 5O 7A (7B.7C)");1K J;o.4P("3p"),a(19).5R(B(){w.5S()})},4a:B(a,b,d){J c.4a(a,b,d),A.14(a)},14:B(a){J 39 c(a)},1F:B(a){J A.14(a).1F(),A},1o:B(a){J A.14(a).1o(),A},2y:B(a){J A.14(a).2y(),A},2o:B(a){J A.14(a).2o(),A},1f:B(a){J A.14(a).1f(),A},4R:B(){J w.4R(),A},4S:B(a){J w.4S(a),A},4T:B(a){J w.4T(a),A},1A:B(b){P(m.2n(b))J w.4U(b);P(a.11(b)!="4V"){I b=a(b),c=0;J a.17(b,B(a,b){w.4U(b)&&c++}),c}J w.3q().1p}}}()),a.U(c,{4a:B(b,c,d){P(b){I e=d||{},f=[];J m.2n(b)?f.1P(39 k(b,c,e)):a(b).17(B(a,b){f.1P(39 k(b,c,e))}),f}}}),a.U(c.37,{3r:B(){J w.27.4b={x:0,y:0},w.14(A.Q)},1F:B(){J a.17(A.3r(),B(a,b){b.1F()}),A},1o:B(){J a.17(A.3r(),B(a,b){b.1o()}),A},2y:B(){J a.17(A.3r(),B(a,b){b.2y()}),A},2o:B(){J a.17(A.3r(),B(a,b){b.2o()}),A},1f:B(){J w.1f(A.Q),A}});I p={5T:B(b,c){I d=a.U({F:0,E:0,D:0,H:0,X:0},c||{}),e=d.E,g=d.F,h=d.D,i=d.H;(d=d.X)?(b.1G(),b.2M(e+d,g),b.1D(e+h-d,g+d,d,f(-1Q),f(0),!1),b.1D(e+h-d,g+i-d,d,f(0),f(1Q),!1),b.1D(e+d,g+i-d,d,f(1Q),f(2e),!1),b.1D(e+d,g+d,d,f(-2e),f(-1Q),!1),b.1H(),b.2p()):b.5U(e,g,h,i)},5V:B(b,c,d){1z(I d=a.U({x:0,y:0,1c:"#3R"},d||{}),e=0,f=c.1p;e<f;e++)1z(I g=0,h=c[e].1p;g<h;g++){I i=26(c[e].2V(g))*(1/9);b.2g=s.2h(d.1c,i),i&&b.5U(d.x+g,d.y+e,1,1)}},3s:B(b,c,d){I e;J a.11(c)=="28"?e=s.2h(c):a.11(c.1c)=="28"?e=s.2h(c.1c,a.11(c.1j)=="29"?c.1j:1):a.4W(c.1c)&&(d=a.U({3a:0,3b:0,3c:0,3d:0},d||{}),e=p.5W.5X(b.7D(d.3a,d.3b,d.3c,d.3d),c.1c,c.1j)),e},5W:{5X:B(b,c,d){1z(I d=a.11(d)=="29"?d:1,e=0,f=c.1p;e<f;e++){I g=c[e];P(a.11(g.1j)=="4V"||a.11(g.1j)!="29")g.1j=1;b.7E(g.L,s.2h(g.1c,g.1j*d))}J b}}},q={3t:"3e,3u,3f,3g,3v,3w,3x,3y,3z,3A,3B,3h".2z(","),3C:{5Y:/^(F|E|1u|1v)(F|E|1u|1v|2q|2r)$/,1s:/^(F|1u)/,2W:/(2q|2r)/,5Z:/^(F|1u|E|1v)/},60:B(){I a={F:"H",E:"D",1u:"H",1v:"D"};J B(b){J a[b]}}(),2W:B(a){J!!a.2X().2R(A.3C.2W)},4X:B(a){J!A.2W(a)},2i:B(a){J a.2X().2R(A.3C.1s)?"1s":"1X"},4Y:B(a){I b=1g;J(a=a.2X().2R(A.3C.5Z))&&a[1]&&(b=a[1]),b},2z:B(a){J a.2X().2R(A.3C.5Y)}},r={4Z:B(a){J a=a.G.T,{D:a.D,H:a.H}},3D:B(b,c,d){J d=a.U({3i:"1i"},d||{}),b=b.G.T,c=A.4c(b.D,b.H,c),d.3i&&(c.D=K[d.3i](c.D),c.H=K[d.3i](c.H)),{D:c.D,H:c.H}},4c:B(a,b,c){I d=2e-e(K.61(b/a*.5));J c*=K.4d(f(d-1Q)),c=a+c*2,{D:c,H:c*b/a}},2Y:B(a,b){I c=A.3D(a,b),d=A.4Z(a);q.2W(a.1t);I e=K.1i(c.H+b);J{2A:{N:{D:K.1i(c.D),H:K.1i(e)}},R:{N:c},T:{N:{D:d.D,H:d.H}}}},52:B(b,c,d){I e={F:0,E:0},f={F:0,E:0},g=a.U({},c),h=b.R,i=i||A.2Y(b,b.R),j=i.2A.N;d&&(j.H=d,h=0);P(b.G.T){I k=q.4Y(b.1t);k=="F"?e.F=j.H-h:k=="E"&&(e.E=j.H-h);I d=q.2z(b.1t),l=q.2i(b.1t);P(l=="1s"){1n(d[2]){O"2q":O"2r":f.E=.5*g.D;15;O"1v":f.E=g.D}d[1]=="1u"&&(f.F=g.H-h+j.H)}1K{1n(d[2]){O"2q":O"2r":f.F=.5*g.H;15;O"1u":f.F=g.H}d[1]=="1v"&&(f.E=g.D-h+j.H)}g[q.60(k)]+=j.H-h}1K P(d=q.2z(b.1t),l=q.2i(b.1t),l=="1s"){1n(d[2]){O"2q":O"2r":f.E=.5*g.D;15;O"1v":f.E=g.D}d[1]=="1u"&&(f.F=g.H)}1K{1n(d[2]){O"2q":O"2r":f.F=.5*g.H;15;O"1u":f.F=g.H}d[1]=="1v"&&(f.E=g.D)}I m=b.G.X&&b.G.X.2a||0,h=b.G.R&&b.G.R.2a||0;P(b.G.T){I n=b.G.T&&b.G.T.1d||{x:0,y:0},k=m&&b.G.X.L=="S"?m:0,m=m&&b.G.X.L=="R"?m:m+h,o=h+k+.5*i.T.N.D-.5*i.R.N.D,i=K.1i(h+k+.5*i.T.N.D+(m>o?m-o:0));P(l=="1s")1n(d[2]){O"E":f.E+=i;15;O"1v":f.E-=i}1K 1n(d[2]){O"F":f.F+=i;15;O"1u":f.F-=i}}P(b.G.T&&(n=b.G.T.1d))P(l=="1s")1n(d[2]){O"E":f.E+=n.x;15;O"1v":f.E-=n.x}1K 1n(d[2]){O"F":f.F+=n.y;15;O"1u":f.F-=n.y}I p;P(b.G.T&&(p=b.G.T.7F))P(l=="1s")1n(d[1]){O"F":f.F-=p;15;O"1u":f.F+=p}1K 1n(d[1]){O"E":f.E-=p;15;O"1v":f.E+=p}J{N:g,L:{F:0,E:0},S:{L:e,N:c},T:{N:j},1S:f}}},s=B(){B b(a){J a.62=a[0],a.63=a[1],a.64=a[2],a}B c(a){I c=5A(3);a.2K("#")==0&&(a=a.4e(1)),a=a.2X();P(a.5K(d,"")!="")J 1g;a.1p==3?(c[0]=a.2V(0)+a.2V(0),c[1]=a.2V(1)+a.2V(1),c[2]=a.2V(2)+a.2V(2)):(c[0]=a.4e(0,2),c[1]=a.4e(2,4),c[2]=a.4e(4));1z(a=0;a<c.1p;a++)c[a]=26(c[a],16);J b(c)}I d=5G("[7G]","g");J{7H:c,2h:B(b,d){a.11(d)=="4V"&&(d=1);I e=d,f=c(b);J f[3]=e,f.1j=e,"7I("+f.7J()+")"},65:B(a){I a=c(a),a=b(a),d=a.62,e=a.63,f=a.64,g,h=d>e?d:e;f>h&&(h=f);I i=d<e?d:e;f<i&&(i=f),g=h/7K,a=h!=0?(h-i)/h:0;P(a==0)d=0;1K{I j=(h-d)/(h-i),k=(h-e)/(h-i),f=(h-f)/(h-i),d=d==h?f-k:e==h?2+j-f:4+k-j;d/=6,d<0&&(d+=1)}J d=K.1I(d*66),a=K.1I(a*53),g=K.1I(g*53),e=[],e[0]=d,e[1]=a,e[2]=g,e.7L=d,e.7M=a,e.7N=g,"#"+(e[2]>50?"3R":"7O")}}}(),t={3E:[],14:B(b){P(!b)J 1g;I c=1g;J a.17(A.3E,B(a,d){d.Q==b&&(c=d)}),c},2H:B(a){A.3E.1P(a)},1f:B(a){P(a=A.14(a))A.3E=m.3o(A.3E,a),a.1f()}};a.U(g.37,B(){J{4f:B(){I a=A.1J();A.2I=a.Y.2I,a=a.G,A.X=a.X&&a.X.2a||0,A.R=a.R&&a.R.2a||0,A.1L=a.1L,a=K.54(A.2I.H,A.2I.D),A.X>a/2&&(A.X=K.55(a/2)),A.G.X.L=="R"&&A.X>A.R&&(A.R=A.X),A.Y={G:{X:A.X,R:A.R,1L:A.1L}}},67:B(){A.Y.W={};I b=A.1t;a.17(q.3t,a.1k(B(a,b){I c;A.Y.W[b]={},A.1t=b,c=A.1T(),A.Y.W[b].1S=c.1S,A.Y.W[b].1e={N:c.1e.N,L:{F:c.1e.L.F,E:c.1e.L.E}},A.Y.W[b].1b={N:c.1C.N},A.12&&(c=A.12.1T(),A.Y.W[b].1S=c.1S,A.Y.W[b].1e.L.F+=c.1C.L.F,A.Y.W[b].1e.L.E+=c.1C.L.E,A.Y.W[b].1b.N=c.1b.N)},A)),A.1t=b},1m:B(){A.2B(),1q.1W&&1q.1W.7P(19);I b=A.1J(),c=A.G;a(A.1e=19.1r("1M")).1w({"1R":"7Q"}),a(b.4g).1E(A.1e),A.4f(),A.68(b),c.1a&&(A.69(b),c.1a.12)&&(A.2s?(A.2s.G=c.1a.12,A.2s.1m()):A.2s=39 i(A.Q,a.U({2f:A.1U},c.1a.12))),A.4h(),c.12&&(A.12?(A.12.G=c.12,A.12.1m()):A.12=39 h(A.Q,A,a.U({2f:A.1U},c.12))),A.67()},1f:B(){A.2B(),A.G.12&&(u.1f(A.Q),A.G.1a&&A.G.1a.12&&v.1f(A.Q)),A.V&&(a(A.V).1f(),A.V=1g)},2B:B(){A.1e&&(A.1a&&(a(A.1a).1f(),A.56=A.57=A.1a=1g),a(A.1e).1f(),A.1e=A.S=A.T=1g,A.Y={})},1J:B(){J w.14(A.Q)[0]},2o:B(){I b=A.1J(),c=a(b.V),d=a(b.V).7R(".6a").6b()[0];P(d){a(d).Z({D:"58",H:"58"});I e=26(c.Z("F")),f=26(c.Z("E")),g=26(c.Z("D"));c.Z({E:"-6c",F:"-6c",D:"7S",H:"58"});I h=w.4i.59(d);b.G.2N&&a.11(b.G.2N)=="29"&&h.D>b.G.2N&&(a(d).Z({D:b.G.2N+"24"}),h=w.4i.59(d)),b.Y.2I=h,c.Z({E:f+"24",F:e+"24",D:g+"24"}),A.1m()}},3F:B(a){A.1t!=a&&(A.1t=a,A.1m())},69:B(b){I c=b.G.1a,c={D:c.2Z+2*c.R,H:c.2Z+2*c.R};a(b.V).1E(a(A.1a=19.1r("1M")).1w({"1R":"6d"}).Z(d(c)).1E(a(A.6e=19.1r("1M")).1w({"1R":"7T"}).Z(d(c)))),A.5a(b,"5b"),A.5a(b,"5c"),a(A.1a).3j("3G",a.1k(A.6f,A)).3j("5d",a.1k(A.6g,A))},5a:B(b,c){I e=b.G.1a,g=e.2Z,h=e.R||0,i=e.x.2Z,j=e.x.2a,e=e.1V[c||"5b"],k={D:g+2*h,H:g+2*h};i>=g&&(i=g-2);I l;a(A.6e).1E(a(A[c+"7U"]=19.1r("1M")).1w({"1R":"7V"}).Z(a.U(d(k),{E:(c=="5c"?k.D:0)+"24"})).1E(a(l=19.1r("2L")).1w(k))),1q.1W&&1W.3H(l),l=l.2U("2d"),l.2f=A.1U,l.7W(k.D/2,k.H/2),l.2g=p.3s(l,e.S,{3a:0,3b:0-g/2,3c:0,3d:0+g/2}),l.1G(),l.1D(0,0,g/2,0,K.2w*2,!0),l.1H(),l.2p(),h&&(l.2g=p.3s(l,e.R,{3a:0,3b:0-g/2-h,3c:0,3d:0+g/2+h}),l.1G(),l.1D(0,0,g/2,K.2w,0,!1),l.M((g+h)/2,0),l.1D(0,0,g/2+h,0,K.2w,!0),l.1D(0,0,g/2+h,K.2w,0,!0),l.M(g/2,0),l.1D(0,0,g/2,0,K.2w,!1),l.1H(),l.2p()),g=i/2,j/=2,j>g&&(h=j,j=g,g=h),l.2g=s.2h(e.x.1c||e.x,e.x.1j||1),l.4j(f(45)),l.1G(),l.2M(0,0),l.M(0,g);1z(e=0;e<4;e++)l.M(0,g),l.M(j,g),l.M(j,g-(g-j)),l.M(g,j),l.M(g,0),l.4j(f(1Q));l.1H(),l.2p()},68:B(b){I c=A.1T(),d=A.G.T&&A.3I(),e=A.1t&&A.1t.2X(),f=A.X,g=A.R,h=b.G.T&&b.G.T.1d||{x:0,y:0},i=0,j=0;f&&(i=A.G.X.L=="S"?f:0,j=A.G.X.L=="R"?f:i+g),A.2O=19.1r("2L"),a(A.2O).1w(c.1e.N),a(A.1e).1E(A.2O),1q.1W&&1W.3H(A.2O),f=A.2O.2U("2d"),f.2f=A.1U,f.2g=p.3s(f,A.G.S,{3a:0,3b:c.S.L.F+g,3c:0,3d:c.S.L.F+c.S.N.H-g}),f.7X=0,A.5e(f,{1G:!0,1H:!0,R:g,X:i,4k:j,30:c,31:d,T:A.G.T,32:e,33:h}),f.2p();1z(I k=["7Y","6h","7Z","6h","80"],l=0,m=k.1p,n=0,o=k.1p;n<o;n++)l=K.1l(l,k[n].1p);o=n=5;P(b=b.2C.3J)b=a(b),n=26(b.Z("1L-E"))||0,o=26(b.Z("1L-F"))||0;p.5V(f,k,{x:c.S.L.E+c.S.N.D-g-(n||0)-l,y:c.S.L.F+c.S.N.H-g-(o||0)-m,1c:s.65(a.4W(A.G.S.1c)?A.G.S.1c[A.G.S.1c.1p-1].1c:A.G.S.1c)}),g&&(b=p.3s(f,A.G.R,{3a:0,3b:c.S.L.F,3c:0,3d:c.S.L.F+c.S.N.H}),f.2g=b,A.5e(f,{1G:!0,1H:!1,R:g,X:i,4k:j,30:c,31:d,T:A.G.T,32:e,33:h}),A.6i(f,{1G:!1,1H:!0,R:g,6j:i,X:{2a:j,L:A.G.X.L},30:c,31:d,T:A.G.T,32:e,33:h}),f.2p())},5e:B(b,c){I d=a.U({T:!1,32:1g,1G:!1,1H:!1,30:1g,31:1g,X:0,R:0,4k:0,33:{x:0,y:0}},c||{}),e=d.30,g=d.31,h=d.33,i=d.R,j=d.X,k=d.32,l=e.S.L,e=e.S.N,m,n,o;g&&(m=g.T.N,n=g.2A.N,o=d.4k,g=i+j+.5*m.D-.5*g.R.N.D,o=K.1i(o>g?o-g:0));I p,g=j?l.E+i+j:l.E+i;p=l.F+i,h&&h.x&&/^(3e|3h)$/.4l(k)&&(g+=h.x),d.1G&&b.1G(),b.2M(g,p);P(d.T)1n(k){O"3e":g=l.E+i,j&&(g+=j),g+=K.1l(o,h.x||0),b.M(g,p),p-=m.H,g+=m.D*.5,b.M(g,p),p+=m.H,g+=m.D*.5,b.M(g,p);15;O"3u":O"4m":g=l.E+e.D*.5-m.D*.5,b.M(g,p),p-=m.H,g+=m.D*.5,b.M(g,p),p+=m.H,g+=m.D*.5,b.M(g,p),g=l.E+e.D*.5-n.D*.5,b.M(g,p);15;O"3f":g=l.E+e.D-i-m.D,j&&(g-=j),g-=K.1l(o,h.x||0),b.M(g,p),p-=m.H,g+=m.D*.5,b.M(g,p),p+=m.H,g+=m.D*.5,b.M(g,p)}j?j&&(b.1D(l.E+e.D-i-j,l.F+i+j,j,f(-1Q),f(0),!1),g=l.E+e.D-i,p=l.F+i+j):(g=l.E+e.D-i,p=l.F+i,b.M(g,p));P(d.T)1n(k){O"3g":p=l.F+i,j&&(p+=j),p+=K.1l(o,h.y||0),b.M(g,p),g+=m.H,p+=m.D*.5,b.M(g,p),g-=m.H,p+=m.D*.5,b.M(g,p);15;O"3v":O"4n":p=l.F+e.H*.5-m.D*.5,b.M(g,p),g+=m.H,p+=m.D*.5,b.M(g,p),g-=m.H,p+=m.D*.5,b.M(g,p);15;O"3w":p=l.F+e.H-i,j&&(p-=j),p-=m.D,p-=K.1l(o,h.y||0),b.M(g,p),g+=m.H,p+=m.D*.5,b.M(g,p),g-=m.H,p+=m.D*.5,b.M(g,p)}j?j&&(b.1D(l.E+e.D-i-j,l.F+e.H-i-j,j,f(0),f(1Q),!1),g=l.E+e.D-i-j,p=l.F+e.H-i):(g=l.E+e.D-i,p=l.F+e.H-i,b.M(g,p));P(d.T)1n(k){O"3x":g=l.E+e.D-i,j&&(g-=j),g-=K.1l(o,h.x||0),b.M(g,p),g-=m.D*.5,p+=m.H,b.M(g,p),g-=m.D*.5,p-=m.H,b.M(g,p);15;O"3y":O"4o":g=l.E+e.D*.5+m.D*.5,b.M(g,p),g-=m.D*.5,p+=m.H,b.M(g,p),g-=m.D*.5,p-=m.H,b.M(g,p);15;O"3z":g=l.E+i+m.D,j&&(g+=j),g+=K.1l(o,h.x||0),b.M(g,p),g-=m.D*.5,p+=m.H,b.M(g,p),g-=m.D*.5,p-=m.H,b.M(g,p)}j?j&&(b.1D(l.E+i+j,l.F+e.H-i-j,j,f(1Q),f(2e),!1),g=l.E+i,p=l.F+e.H-i-j):(g=l.E+i,p=l.F+e.H-i,b.M(g,p));P(d.T)1n(k){O"3A":p=l.F+e.H-i,j&&(p-=j),p-=K.1l(o,h.y||0),b.M(g,p),g-=m.H,p-=m.D*.5,b.M(g,p),g+=m.H,p-=m.D*.5,b.M(g,p);15;O"3B":O"4p":p=l.F+e.H*.5+m.D*.5,b.M(g,p),g-=m.H,p-=m.D*.5,b.M(g,p),g+=m.H,p-=m.D*.5,b.M(g,p);15;O"3h":p=l.F+i+m.D,j&&(p+=j),p+=K.1l(o,h.y||0),b.M(g,p),g-=m.H,p-=m.D*.5,b.M(g,p),g+=m.H,p-=m.D*.5,b.M(g,p)}J j?j&&(b.1D(l.E+i+j,l.F+i+j,j,f(-2e),f(-1Q),!1),g=l.E+i+j,p=l.F+i,g+=1,b.M(g,p)):(g=l.E+i,p=l.F+i,b.M(g,p)),d.1H&&b.1H(),{x:g,y:p}},6i:B(b,c){I d=a.U({T:!1,32:1g,1G:!1,1H:!1,30:1g,31:1g,X:0,R:0,81:0,33:{x:0,y:0}},c||{}),e=d.30,g=d.31,h=d.33,i=d.R,j=d.X&&d.X.2a||0,k=d.6j,l=d.32,m=e.S.L,e=e.S.N,n,o,p;g&&(n=g.T.N,o=g.R.N,p=i+k+.5*n.D-.5*o.D,p=K.1i(j>p?j-p:0));I g=m.E+i+k,q=m.F+i;k&&(g+=1),a.U({},{x:g,y:q}),d.1G&&b.1G();I r=a.U({},{x:g,y:q});q-=i,b.M(g,q),j?j&&(b.1D(m.E+j,m.F+j,j,f(-1Q),f(-2e),!0),g=m.E,q=m.F+j):(g=m.E,q=m.F,b.M(g,q));P(d.T)1n(l){O"3h":q=m.F+i,k&&(q+=k),q-=o.D*.5,q+=n.D*.5,q+=K.1l(p,h.y||0),b.M(g,q),g-=o.H,q+=o.D*.5,b.M(g,q),g+=o.H,q+=o.D*.5,b.M(g,q);15;O"3B":O"4p":q=m.F+e.H*.5-o.D*.5,b.M(g,q),g-=o.H,q+=o.D*.5,b.M(g,q),g+=o.H,q+=o.D*.5,b.M(g,q);15;O"3A":q=m.F+e.H-i-o.D,k&&(q-=k),q+=o.D*.5,q-=n.D*.5,q-=K.1l(p,h.y||0),b.M(g,q),g-=o.H,q+=o.D*.5,b.M(g,q),g+=o.H,q+=o.D*.5,b.M(g,q)}j?j&&(b.1D(m.E+j,m.F+e.H-j,j,f(-2e),f(-82),!0),g=m.E+j,q=m.F+e.H):(g=m.E,q=m.F+e.H,b.M(g,q));P(d.T)1n(l){O"3z":g=m.E+i,k&&(g+=k),g-=o.D*.5,g+=n.D*.5,g+=K.1l(p,h.x||0),b.M(g,q),q+=o.H,g+=o.D*.5,b.M(g,q),q-=o.H,g+=o.D*.5,b.M(g,q);15;O"3y":O"4o":g=m.E+e.D*.5-o.D*.5,b.M(g,q),q+=o.H,g+=o.D*.5,b.M(g,q),q-=o.H,g+=o.D*.5,b.M(g,q),g=m.E+e.D*.5+o.D,b.M(g,q);15;O"3x":g=m.E+e.D-i-o.D,k&&(g-=k),g+=o.D*.5,g-=n.D*.5,g-=K.1l(p,h.x||0),b.M(g,q),q+=o.H,g+=o.D*.5,b.M(g,q),q-=o.H,g+=o.D*.5,b.M(g,q)}j?j&&(b.1D(m.E+e.D-j,m.F+e.H-j,j,f(1Q),f(0),!0),g=m.E+e.D,q=m.F+e.D+j):(g=m.E+e.D,q=m.F+e.H,b.M(g,q));P(d.T)1n(l){O"3w":q=m.F+e.H-i,q+=o.D*.5,q-=n.D*.5,k&&(q-=k),q-=K.1l(p,h.y||0),b.M(g,q),g+=o.H,q-=o.D*.5,b.M(g,q),g-=o.H,q-=o.D*.5,b.M(g,q);15;O"3v":O"4n":q=m.F+e.H*.5+o.D*.5,b.M(g,q),g+=o.H,q-=o.D*.5,b.M(g,q),g-=o.H,q-=o.D*.5,b.M(g,q);15;O"3g":q=m.F+i,k&&(q+=k),q+=o.D,q-=o.D*.5-n.D*.5,q+=K.1l(p,h.y||0),b.M(g,q),g+=o.H,q-=o.D*.5,b.M(g,q),g-=o.H,q-=o.D*.5,b.M(g,q)}j?j&&(b.1D(m.E+e.D-j,m.F+j,j,f(0),f(-1Q),!0),q=m.F):(g=m.E+e.D,q=m.F,b.M(g,q));P(d.T)1n(l){O"3f":g=m.E+e.D-i,g+=o.D*.5-n.D*.5,k&&(g-=k),g-=K.1l(p,h.x||0),b.M(g,q),q-=o.H,g-=o.D*.5,b.M(g,q),q+=o.H,g-=o.D*.5,b.M(g,q);15;O"3u":O"4m":g=m.E+e.D*.5+o.D*.5,b.M(g,q),q-=o.H,g-=o.D*.5,b.M(g,q),q+=o.H,g-=o.D*.5,b.M(g,q),g=m.E+e.D*.5-o.D,b.M(g,q),b.M(g,q);15;O"3e":g=m.E+i+o.D,g-=o.D*.5,g+=n.D*.5,k&&(g+=k),g+=K.1l(p,h.x||0),b.M(g,q),q-=o.H,g-=o.D*.5,b.M(g,q),q+=o.H,g-=o.D*.5,b.M(g,q)}b.M(r.x,r.y-i),b.M(r.x,r.y),d.1H&&b.1H()},6f:B(){I b=A.1J().G.1a,b=b.2Z+b.R*2;a(A.57).Z({E:-1*b+"24"}),a(A.56).Z({E:0})},6g:B(){I b=A.1J().G.1a,b=b.2Z+b.R*2;a(A.57).Z({E:0}),a(A.56).Z({E:b+"24"})},3I:B(){J r.2Y(A,A.R)},1T:B(){I a,b,c,d,e,g,h=A.2I,i=A.1J().G,j=A.X,k=A.R,l=A.1L,h={D:k*2+l*2+h.D,H:k*2+l*2+h.H};A.G.T&&A.3I();I m=r.52(A,h),l=m.N,n=m.L,h=m.S.N,o=m.S.L,p=0,q=0,s=l.D,t=l.H;J i.1a&&(e=j,i.X.L=="S"&&(e+=k),p=e-K.83(f(45))*e,k="1v",A.1t.2X().2R(/^(3f|3g)$/)&&(k="E"),i=i.1a.2Z+2*i.1a.R,e=i,g=i,q=o.E-i/2+(k=="E"?p:h.D-p),p=o.F-i/2+p,k=="E"?q<0&&(i=K.2j(q),s+=i,n.E+=i,q=0):(i=q+i-s,i>0&&(s+=i)),p<0&&(i=K.2j(p),t+=i,n.F+=i,p=0),A.G.1a.12)&&(a=A.G.1a.12,b=a.2x,i=a.1d,c=e+2*b,d=g+2*b,a=p-b+i.y,b=q-b+i.x,k=="E"?b<0&&(i=K.2j(b),s+=i,n.E+=i,q+=i,b=0):(i=b+c-s,i>0&&(s+=i)),a<0&&(i=K.2j(a),t+=i,n.F+=i,p+=i,a=0)),m=m.1S,m.F+=n.F,m.E+=n.E,k={E:K.1i(n.E+o.E+A.R+A.G.1L),F:K.1i(n.F+o.F+A.R+A.G.1L)},h={1b:{N:{D:K.1i(s),H:K.1i(t)}},1C:{N:{D:K.1i(s),H:K.1i(t)}},1e:{N:l,L:{F:K.1I(n.F),E:K.1I(n.E)}},S:{N:{D:K.1i(h.D),H:K.1i(h.H)},L:{F:K.1I(o.F),E:K.1I(o.E)}},1S:{F:K.1I(m.F),E:K.1I(m.E)},2P:{L:k}},A.G.1a&&(h.1a={N:{D:K.1i(e),H:K.1i(g)},L:{F:K.1I(p),E:K.1I(q)}},A.G.1a.12)&&(h.2s={N:{D:K.1i(c),H:K.1i(d)},L:{F:K.1I(a),E:K.1I(b)}}),h},4h:B(){I b=A.1T(),c=A.1J();a(c.V).Z(d(b.1b.N)),a(c.4g).Z(d(b.1C.N)),a(A.1e).Z(a.U(d(b.1e.N),d(b.1e.L))),A.1a&&(a(A.1a).Z(d(b.1a.L)),b.2s&&a(A.2s.V).Z(d(b.2s.L))),a(c.2C).Z(d(b.2P.L))},6k:B(a){A.1U=a||0,A.12&&(A.12.1U=A.1U)},84:B(a){A.6k(a),A.1m()}}}());I u={2t:[],14:B(b){P(!b)J 1g;I c=1g;J a.17(A.2t,B(a,d){d.Q==b&&(c=d)}),c},2H:B(a){A.2t.1P(a)},1f:B(a){P(a=A.14(a))A.2t=m.3o(A.2t,a),a.1f()},3K:B(a){J K.2w/2-K.48(a,K.4d(a)*K.2w)},3k:{3D:B(a,b){I c=t.14(a.Q).3I().R.N,c=A.4c(c.D,c.H,b,{3i:!1});J{D:c.D,H:c.H}},85:B(a,b,c){I d=a*.5,g=2e-e(K.86(d/K.6l(d*d+b*b)))-1Q,g=f(g);J c*=1/K.4d(g),d=(d+c)*2,{D:d,H:d/a*b}},4c:B(a,b,c){I d=2e-e(K.61(b/a*.5));J c*=K.4d(f(d-1Q)),c=a+c*2,{D:c,H:c*b/a}},2Y:B(b){I c=t.14(b.Q),d=b.G.2x,e=q.4X(c.1t);q.2i(c.1t),c=u.3k.3D(b,d),c={2A:{N:{D:K.1i(c.D),H:K.1i(c.H)},L:{F:0,E:0}}};P(d){c.2b=[];1z(I f=0;f<=d;f++){I g=u.3k.3D(b,f,{3i:!1});c.2b.1P({L:{F:c.2A.N.H-g.H,E:e?d-f:(c.2A.N.D-g.D)/2},N:g})}}1K c.2b=[a.U({},c.2A)];J c},4j:B(a,b,c){r.4j(a,b.2D(),c)}}};a.U(h.37,B(){J{4f:B(){},1f:B(){A.2B()},2B:B(){A.V&&(a(A.V).1f(),A.V=A.1e=A.S=A.T=1g,A.Y={})},1m:B(){A.2B(),A.4f();I b=A.1J(),c=A.2D();A.V=19.1r("1M"),a(A.V).1w({"1R":"87"}),a(b.V).88(A.V),c.1T(),a(A.V).Z({F:0,E:0}),A.6m(),A.4h()},1J:B(){J w.14(A.Q)[0]},2D:B(){J t.14(A.Q)},1T:B(){I b=A.2D(),c=b.1T();A.1J();I d=A.G.2x,e=a.U({},c.S.N);e.D+=2*d,e.H+=2*d;I f;b.G.T&&(f=u.3k.2Y(A).2A.N,f=f.H);I g=r.52(b,e,f);f=g.N;I h=g.L,e=g.S.N,g=g.S.L,i=c.1e.L,j=c.S.L,d={F:i.F+j.F-(g.F+d)+A.G.1d.y,E:i.E+j.E-(g.E+d)+A.G.1d.x},i=c.1S,j=c.1C.N,k={F:0,E:0};P(d.F<0){I l=K.2j(d.F);k.F+=l,d.F=0,i.F+=l}J d.E<0&&(l=K.2j(d.E),k.E+=l,d.E=0,i.E+=l),l={H:K.1l(f.H+d.F,j.H+k.F),D:K.1l(f.D+d.E,j.D+k.E)},b={E:K.1i(k.E+c.1e.L.E+c.S.L.E+b.R+b.1L),F:K.1i(k.F+c.1e.L.F+c.S.L.F+b.R+b.1L)},{1b:{N:l},1C:{N:j,L:k},V:{N:f,L:d},1e:{N:f,L:{F:K.1I(h.F),E:K.1I(h.E)}},S:{N:{D:K.1i(e.D),H:K.1i(e.H)},L:{F:K.1I(g.F),E:K.1I(g.E)}},1S:i,2P:{L:b}}},5f:B(){J A.G.1j/(A.G.2x+1)},6m:B(){I b=A.2D(),c=b.1T(),e=A.1J(),f=A.1T(),g=A.G.2x,h=u.3k.2Y(A),i=b.1t,j=q.4Y(i),k=g,l=g;P(e.G.T){I m=h.2b[h.2b.1p-1];j=="E"&&(l+=K.1i(m.N.H)),j=="F"&&(k+=K.1i(m.N.H))}I n=b.Y.G,m=n.X,n=n.R;e.G.X.L=="S"&&m&&(m+=n),a(A.V).1E(a(A.1e=19.1r("1M")).1w({"1R":"89"}).Z(d(f.1e.N)).1E(a(A.2O=19.1r("2L")).1w(f.1e.N))).Z(d(f.1e.N)),1q.1W&&1W.3H(A.2O),e=A.2O.2U("2d"),e.2f=A.1U;1z(I f=g+1,o=0;o<=g;o++)e.2g=s.2h(A.G.1c,u.3K(o*(1/f))*(A.G.1j/f)),p.5T(e,{D:c.S.N.D+o*2,H:c.S.N.H+o*2,F:k-o,E:l-o,X:m+o});P(b.G.T){I o=h.2b[0].N,r=b.G.T,g=n;g+=r.D*.5;I t=b.G.X&&b.G.X.L=="S"?b.G.X.2a||0:0;t&&(g+=t),n=n+t+.5*r.D-.5*o.D,m=K.1i(m>n?m-n:0),g+=K.1l(m,b.G.T.1d&&b.G.T.1d[j&&/^(E|1v)$/.4l(j)?"y":"x"]||0);P(j=="F"||j=="1u"){1n(i){O"3e":O"3z":l+=g;15;O"3u":O"4m":O"3y":O"4o":l+=c.S.N.D*.5;15;O"3f":O"3x":l+=c.S.N.D-g}j=="1u"&&(k+=c.S.N.H),o=0;1z(b=h.2b.1p;o<b;o++)e.2g=s.2h(A.G.1c,u.3K(o*(1/f))*(A.G.1j/f)),g=h.2b[o],e.1G(),j=="F"?(e.2M(l,k-o),e.M(l-g.N.D*.5,k-o),e.M(l,k-o-g.N.H),e.M(l+g.N.D*.5,k-o)):(e.2M(l,k+o),e.M(l-g.N.D*.5,k+o),e.M(l,k+o+g.N.H),e.M(l+g.N.D*.5,k+o)),e.1H(),e.2p()}1K{1n(i){O"3h":O"3g":k+=g;15;O"3B":O"4p":O"3v":O"4n":k+=c.S.N.H*.5;15;O"3A":O"3w":k+=c.S.N.H-g}j=="1v"&&(l+=c.S.N.D),o=0;1z(b=h.2b.1p;o<b;o++)e.2g=s.2h(A.G.1c,u.3K(o*(1/f))*(A.G.1j/f)),g=h.2b[o],e.1G(),j=="E"?(e.2M(l-o,k),e.M(l-o,k-g.N.D*.5),e.M(l-o-g.N.H,k),e.M(l-o,k+g.N.D*.5)):(e.2M(l+o,k),e.M(l+o,k-g.N.D*.5),e.M(l+o+g.N.H,k),e.M(l+o,k+g.N.D*.5)),e.1H(),e.2p()}}},8a:B(){I b=A.2D(),c=u.3k.2Y(A),e=c.2A.N;q.4X(b.1t);I f=q.2i(b.1t),g=K.1l(e.D,e.H),b=g/2;g/=2,f={D:e[f=="1X"?"H":"D"],H:e[f=="1X"?"D":"H"]},a(A.1e).1E(a(A.T=19.1r("1M")).1w({"1R":"8b"}).Z(d(f)).1E(a(A.5g=19.1r("2L")).1w(f))),1q.1W&&1W.3H(A.5g),f=A.5g.2U("2d"),f.2f=A.1U,f.2g=s.2h(A.G.1c,A.5f());1z(I h=0,i=c.2b.1p;h<i;h++){I j=c.2b[h];f.1G(),f.2M(e.D/2-b,j.L.F-g),f.M(j.L.E-b,e.H-h-g),f.M(j.L.E+j.N.D-b,e.H-h-g),f.1H(),f.2p()}},4h:B(){I b=A.1T(),c=A.2D(),e=A.1J();a(e.V).Z(d(b.1b.N)),a(e.4g).Z(a.U(d(b.1C.L),d(b.1C.N)));P(e.G.1a){I f=c.1T(),g=b.1C.L,h=f.1a.L;a(c.1a).Z(d({F:g.F+h.F,E:g.E+h.E})),e.G.1a.12&&(f=f.2s.L,a(c.2s.V).Z(d({F:g.F+f.F,E:g.E+f.E})))}a(A.V).Z(a.U(d(b.V.N),d(b.V.L))),a(A.1e).Z(d(b.1e.N)),a(e.2C).Z(d(b.2P.L))}}}());I v={2t:[],14:B(b){P(!b)J 1g;I c=1g;J a.17(A.2t,B(a,d){d.Q==b&&(c=d)}),c},2H:B(a){A.2t.1P(a)},1f:B(a){P(a=A.14(a))A.2t=m.3o(A.2t,a),a.1f()}};a.U(i.37,B(){J{1m:B(){A.2B(),A.1J();I b=A.2D(),c=b.1T().1a.N,d=a.U({},c),e=A.G.2x;d.D+=e*2,d.H+=e*2,a(b.1a).8c(a(A.V=19.1r("1M")).1w({"1R":"8d"}).1E(a(A.5h=19.1r("2L")).1w(d))),1q.1W&&1W.3H(A.5h),b=A.5h.2U("2d"),b.2f=A.1U;1z(I g=d.D/2,d=d.H/2,c=c.H/2,h=e+1,i=0;i<=e;i++)b.2g=s.2h(A.G.1c,u.3K(i*(1/h))*(A.G.1j/h)),b.1G(),b.1D(g,d,c+i,f(0),f(66),!0),b.1H(),b.2p()},1f:B(){A.2B()},2B:B(){A.V&&(a(A.V).1f(),A.V=1g)},1J:B(){J w.14(A.Q)[0]},2D:B(){J t.14(A.Q)},5f:B(){J A.G.1j/(A.G.2x+1)}}}());I w={1Y:[],G:{3l:"5i",3S:8e},5S:B(){J B(){I b=["2u"];1B.38.4Q&&(b.1P("8f"),a(19.4q).3j("2u",B(){})),a.17(b,B(b,c){a(19.6n).3j(c,B(b){I c=m.4M(b,".3m .6d, .3m .8g");c&&(b.8h(),b.8i(),w.6o(a(c).4N(".3m")[0]).1o())})})}}(),14:B(b){I c=[];J m.2n(b)?a.17(A.1Y,B(a,d){d.Q==b&&c.1P(d)}):a.17(A.1Y,B(d,e){e.Q&&a(e.Q).6p(b)&&c.1P(e)}),c},6o:B(b){P(!b)J 1g;I c=1g;J a.17(A.1Y,B(a,d){d.1x("1m")&&d.V===b&&(c=d)}),c},8j:B(b){I c=[];J a.17(A.1Y,B(d,e){e.Q&&a(e.Q).6p(b)&&c.1P(e)}),c},1F:B(b){m.2n(b)?(b=A.14(b)[0])&&b.1F():a(b).17(a.1k(B(a,b){I c=A.14(b)[0];c&&c.1F()},A))},1o:B(b){m.2n(b)?(b=A.14(b)[0])&&b.1o():a(b).17(a.1k(B(a,b){I c=A.14(b)[0];c&&c.1o()},A))},2y:B(b){m.2n(b)?(b=A.14(b)[0])&&b.2y():a(b).17(a.1k(B(a,b){I c=A.14(b)[0];c&&c.2y()},A))},4R:B(){a.17(A.3q(),B(a,b){b.1o()})},2o:B(b){m.2n(b)?(b=A.14(b)[0])&&b.2o():a(b).17(a.1k(B(a,b){I c=A.14(b)[0];c&&c.2o()},A))},3q:B(){I b=[];J a.17(A.1Y,B(a,c){c.1A()&&b.1P(c)}),b},4U:B(a){J m.2n(a)?m.3X(A.3q()||[],B(b){J b.Q==a}):!1},1A:B(){J m.4J(A.1Y,B(a){J a.1A()})},6q:B(){I b=0,c;J a.17(A.1Y,B(a,d){d.1O>b&&(b=d.1O,c=d)}),c},6r:B(){A.3q().1p<=1&&a.17(A.1Y,B(b,c){c.1x("1m")&&!c.G.1O&&a(c.V).Z({1O:c.1O=+w.G.3S})})},2H:B(a){A.1Y.1P(a)},5j:B(a){P(a=A.14(a)[0])a.1o(),a.1f(),A.1Y=m.3o(A.1Y,a)},1f:B(b){m.2n(b)?A.5j(b):a(b).17(a.1k(B(a,b){A.5j(b)},A)),A.6s()},6s:B(){J B(){a.17(A.1Y,a.1k(B(a,b){I c;P(c=b.Q){1z(c=b.Q;c&&c.42;)c=c.42;c=!c||!c.4q}c&&A.1f(b.Q)},A))}}(),4S:B(a){A.G.3l=a||"5i"},4T:B(a){A.G.3S=a||0},5v:B(){B b(b){J a.11(b)=="28"?{Q:f.1N&&f.1N.Q||e.1N.Q,1Z:b}:j(a.U({},e.1N),b)}B c(b){J e=1B.2k.6t,f=j(a.U({},e),1B.2k.5k),g=1B.2k.5l.6t,h=j(a.U({},g),1B.2k.5l.5k),c=d,d(b)}B d(c){c.1C=c.1C||(1B.2k[w.G.3l]?w.G.3l:"5i");I d=c.1C?a.U({},1B.2k[c.1C]||1B.2k[w.G.3l]):{},d=j(a.U({},f),d),d=j(a.U({},d),c);d.1y&&(a.11(d.1y)=="3L"&&(d.1y={3M:f.1y&&f.1y.3M||e.1y.3M,11:f.1y&&f.1y.11||e.1y.11}),d.1y=j(a.U({},e.1y),d.1y)),d.S&&a.11(d.S)=="28"&&(d.S={1c:d.S,1j:1});P(d.R){I i;i=a.11(d.R)=="29"?{2a:d.R,1c:f.R&&f.R.1c||e.R.1c,1j:f.R&&f.R.1j||e.R.1j}:j(a.U({},e.R),d.R),d.R=i.2a===0?!1:i}d.X&&(i=a.11(d.X)=="29"?{2a:d.X,L:f.X&&f.X.L||e.X.L}:j(a.U({},e.X),d.X),d.X=i.2a===0?!1:i),i=i=d.W&&d.W.1h||a.11(d.W)=="28"&&d.W||f.W&&f.W.1h||a.11(f.W)=="28"&&f.W||e.W&&e.W.1h||e.W;I k=d.W&&d.W.1b||f.W&&f.W.1b||e.W&&e.W.1b||w.27.6u(i);d.W?a.11(d.W)=="28"?i={1h:d.W,1b:w.27.6v(d.W)}:(i={1b:k,1h:i},d.W.1b&&(i.1b=d.W.1b),d.W.1h&&(i.1h=d.W.1h)):i={1b:k,1h:i},d.W=i,d.1h=="2m"?(k=a.U({},e.1d.2m),a.U(k,1B.2k.5k.1d||{}),c.1C&&a.U(k,(1B.2k[c.1C]||1B.2k[w.G.3l]).1d||{}),k=w.27.6w(e.1d.2m,e.W,i.1h),c.1d&&(k=a.U(k,c.1d||{})),d.2E=0):k={x:d.1d.x,y:d.1d.y},d.1d=k;P(d.1a&&d.6x){I c=a.U({},1B.2k.5l[d.6x]),l=j(a.U({},h),c);l.1V&&a.17(["5b","5c"],B(b,c){I d=l.1V[c],e=h.1V&&h.1V[c];P(d.S){I f=e&&e.S;a.11(d.S)=="29"?d.S={1c:f&&f.1c||g.1V[c].S.1c,1j:d.S}:a.11(d.S)=="28"?(f=f&&a.11(f.1j)=="29"&&f.1j||g.1V[c].S.1j,d.S={1c:d.S,1j:f}):d.S=j(a.U({},g.1V[c].S),d.S)}d.R&&(e=e&&e.R,d.R=a.11(d.R)=="29"?{1c:e&&e.1c||g.1V[c].R.1c,1j:d.R}:j(a.U({},g.1V[c].R),d.R))}),l.12&&(c=h.12&&h.12.34&&h.12.34==4B?h.12:g.12,l.12.34&&l.12.34==4B&&(c=j(c,l.12)),l.12=c),d.1a=l}d.12&&(c=a.11(d.12)=="3L"?f.12&&a.11(f.12)=="3L"?e.12:f.12?f.12:e.12:j(a.U({},e.12),d.12||{}),a.11(c.1d)=="29"&&(c.1d={x:c.1d,y:c.1d}),d.12=c),d.T&&(c={},c=a.11(d.T)=="3L"?j({},e.T):j(j({},e.T),a.U({},d.T)),a.11(c.1d)=="29"&&(c.1d={x:c.1d,y:c.1d}),d.T=c),d.20&&(a.11(d.20)=="28"?d.20={4r:d.20,6y:!0}:a.11(d.20)=="3L"&&(d.20=d.20?{4r:"6z",6y:!0}:!1));P(d.1N)P(a.4W(d.1N)){I m=[];a.17(d.1N,B(a,c){m.1P(b(c))}),d.1N=m}1K d.1N=[b(d.1N)];J d.2F&&a.11(d.2F)=="28"&&(d.2F=[""+d.2F]),d.1L=0,d.2c&&(1q.2T?o.4P("2T"):d.2c=!1),d}I e,f,g,h;J c}()};w.27=B(){B b(b,c){I d=q.2z(b),e=d[1],d=d[2],f=q.2i(b),g=a.U({1s:!0,1X:!0},c||{});J f=="1s"?(g.1X&&(e=k[e]),g.1s&&(d=k[d])):(g.1X&&(d=k[d]),g.1s&&(e=k[e])),e+d}B c(b,c){P(b.G.20){I d=c,e=j(b),f=e.N,e=e.L,g=t.14(b.Q).Y.W[d.W.1b].1b.N,h=d.L;e.E>h.E&&(d.L.E=e.E),e.F>h.F&&(d.L.F=e.F),e.E+f.D<h.E+g.D&&(d.L.E=e.E+f.D-g.D),e.F+f.H<h.F+g.H&&(d.L.F=e.F+f.H-g.H),c=d}b.3F(c.W.1b),d=c.L,a(b.V).Z({F:d.F+"24",E:d.E+"24"})}B d(a){J a&&(/^2m|2u|4Q$/.4l(6A a.11=="28"&&a.11||"")||a.5F>=0)}B e(a,b,c,d){I e=a>=c&&a<=d,f=b>=c&&b<=d;J e&&f?b-a:e&&!f?d-a:!e&&f?b-c:(e=c>=a&&c<=b,f=d>=a&&d<=b,e&&f?d-c:e&&!f?b-c:!e&&f?d-a:0)}B f(a,b){I c=a.N.D*a.N.H;J c?e(a.L.E,a.L.E+a.N.D,b.L.E,b.L.E+b.N.D)*e(a.L.F,a.L.F+a.N.H,b.L.F,b.L.F+b.N.H)/c:0}B g(a,b){I c=q.2z(b),d={E:0,F:0};P(q.2i(b)=="1s"){1n(c[2]){O"2q":O"2r":d.E=.5*a.D;15;O"1v":d.E=a.D}c[1]=="1u"&&(d.F=a.H)}1K{1n(c[2]){O"2q":O"2r":d.F=.5*a.H;15;O"1u":d.F=a.H}c[1]=="1v"&&(d.E=a.D)}J d}B h(b){I c=m.Q.43(b),b=m.Q.3Z(b),d=a(1q).40(),e=a(1q).41();J c.E+=-1*(b.E-e),c.F+=-1*(b.F-d),c}B i(c,e,i,k){I n,o,p=t.14(c.Q),r=p.G.1d,s=d(i);s||!i?(o={D:1,H:1},s?(n=m.3Y(i),n={F:n.y,E:n.x}):(n=c.Y.1Z,n={F:n?n.y:0,E:n?n.x:0}),c.Y.1Z={x:n.E,y:n.F}):(n=h(i),o={D:a(i).6B(),H:a(i).6C()});P(p.G.T&&p.G.1h!="2m"){I i=q.2z(k),v=q.2z(e),w=q.2i(k),x=p.Y.G,y=p.3I().R.N,z=x.X,x=x.R,C=z&&p.G.X.L=="S"?z:0,z=z&&p.G.X.L=="R"?z:z+x,y=x+C+.5*p.G.T.D-.5*y.D,y=K.1i(x+C+.5*p.G.T.D+(z>y?z-y:0)+p.G.T.1d[w=="1s"?"x":"y"]);P(w=="1s"&&i[2]=="E"&&v[2]=="E"||i[2]=="1v"&&v[2]=="1v")o.D-=y*2,n.E+=y;1K P(w=="1X"&&i[2]=="F"&&v[2]=="F"||i[2]=="1u"&&v[2]=="1u")o.H-=y*2,n.F+=y}i=a.U({},n),p=s?b(p.G.W.1b):p.G.W.1h,g(o,p),s=g(o,k),n={E:n.E+s.E,F:n.F+s.F},r=a.U({},r),r=l(r,p,k),n.F+=r.y,n.E+=r.x,p=t.14(c.Q),r=p.Y.W,s=a.U({},r[e]),n={F:n.F-s.1S.F,E:n.E-s.1S.E},s.1b.L=n,s={1s:!0,1X:!0};P(c.G.20){P(v=j(c),c=(c.G.12?u.14(c.Q):p).1T().1b.N,s.2v=f({N:c,L:n},v),s.2v<1){P(n.E<v.L.E||n.E+c.D>v.L.E+v.N.D)s.1s=!1;P(n.F<v.L.F||n.F+c.H>v.L.F+v.N.H)s.1X=!1}}1K s.2v=1;J c=r[e].1e,o=f({N:o,L:i},{N:c.N,L:{F:n.F+c.L.F,E:n.E+c.L.E}}),{L:n,2v:{1h:o},3N:s,W:{1b:e,1h:k}}}B j(b){I c={F:a(1q).40(),E:a(1q).41()},d=b.G.1h;P(d=="2m"||d=="3V")d=b.Q;d=a(d).4N(b.G.20.4r).6b()[0];P(!d||b.G.20.4r=="6z")J{N:{D:a(1q).D(),H:a(1q).H()},L:c};I b=m.Q.43(d),e=m.Q.3Z(d);J b.E+=-1*(e.E-c.E),b.F+=-1*(e.F-c.F),{N:{D:a(d).6D(),H:a(d).6E()},L:b}}I k={E:"1v",1v:"E",F:"1u",1u:"F",2q:"2q",2r:"2r"},l=B(){I a=[[-1,-1],[0,-1],[1,-1],[-1,0],[0,0],[1,0],[-1,1],[0,1],[1,1]],b={3h:0,3e:0,3u:1,4m:1,3f:2,3g:2,3v:5,4n:5,3w:8,3x:8,3y:7,4o:7,3z:6,3A:6,3B:3,4p:3};J B(c,d,e){I d=a[b[d]],f=a[b[e]],d=[K.55(K.2j(d[0]-f[0])*.5)?-1:1,K.55(K.2j(d[1]-f[1])*.5)?-1:1];J q.2W(e)&&(q.2i(e)=="1s"?d[0]=0:d[1]=0),{x:d[0]*c.x,y:d[1]*c.y}}}();J{14:i,6F:B(a,d,e,g){I h=i(a,d,e,g);/8k$/.4l(e&&6A e.11=="28"?e.11:"");P(h.3N.2v===1)c(a,h);1K{I j=d,k=g,k={1s:!h.3N.1s,1X:!h.3N.1X};P(!q.2W(d))J j=b(d,k),k=b(g,k),h=i(a,j,e,k),c(a,h),h;P(q.2i(d)=="1s"&&k.1X||q.2i(d)=="1X"&&k.1s)J j=b(d,k),k=b(g,k),h=i(a,j,e,k),c(a,h),h;d=[],g=q.3t,j=0;1z(k=g.1p;j<k;j++)1z(I l=g[j],m=0,n=q.3t.1p;m<n;m++)d.1P(i(a,q.3t[m],e,l));1z(I e=h,o=t.14(a.Q).Y.W,j=o[e.W.1b],g=0,p=e.L.E+j.1S.E,r=e.L.F+j.1S.F,n=0,s=1,u={N:j.1b.N,L:e.L},v=0,j=1,k=0,l=d.1p;k<l;k++){m=d[k],m.2G={},m.2G.20=m.3N.2v;I w=o[m.W.1b].1S,w=K.6l(K.48(K.2j(m.L.E+w.E-p),2)+K.48(K.2j(m.L.F+w.F-r),2)),g=K.1l(g,w);m.2G.6G=w,w=m.2v.1h,s=K.54(s,w),n=K.1l(n,w),m.2G.6H=w,w=f(u,{N:o[m.W.1b].1b.N,L:m.L}),j=K.54(j,w),v=K.1l(v,w),m.2G.6I=w}1z(I o=0,x,n=K.1l(e.2v.1h-s,n-e.2v.1h),s=v-j,k=0,l=d.1p;k<l;k++)m=d[k],v=m.2G.20*51,v+=(1-m.2G.6G/g)*18||18,p=K.2j(e.2v.1h-m.2G.6H)||0,v+=(1-(p/n||1))*8,v+=((m.2G.6I-j)/s||0)*23,o=K.1l(o,v),v==o&&(x=k);c(a,d[x])}J h},6u:b,6v:B(a){J a=q.2z(a),b(a[1]+k[a[2]])},6J:h,6w:l,5m:d}}(),w.27.4b={x:0,y:0},a(19).5R(B(){a(19).3j("4s",B(a){w.27.4b=m.3Y(a)})}),w.4i=B(){B b(b){J{D:a(b).6D(),H:a(b).6E()}}B c(c){I d=b(c),e=c.42;J e&&a(e).Z({D:d.D+"24"})&&b(c).H>d.H&&d.D++,a(e).Z({D:"53%"}),d}J c=m.5B(c,B(a,b){I c=a(b);J c.H+=13,c}),{1m:B(){a(19.4q).1E(a(19.1r("1M")).1w({"1R":"8l"}).1E(a(19.1r("1M")).1w({"1R":"3m"}).1E(a(A.V=19.1r("1M")).1w({"1R":"6K"}))))},3n:B(b,d){A.V||A.1m();I e=19.1r("1M");a(A.V).1E(a(e).1w({"1R":"6a 8m"}).5n(d)),b.G.1C&&a(e).3O("8n"+b.G.1C);I f=c(e),g=f.D-(26(a(e).Z("1L-E"))||0)-(26(a(e).Z("1L-1v"))||0);26(a(e).Z("1L-F")),26(a(e).Z("1L-1u")),b.G.2N&&a.11(b.G.2N)=="29"&&g>b.G.2N&&(a(e).Z({D:b.G.2N+"24"}),f=c(e)),b.Y.2I=f,a(b.2C).5n(e)},59:c}}(),a.U(k.37,B(){J{1m:B(){P(!A.1x("1m")){a(19.4q).1E(a(A.V).Z({E:"-4t",F:"-4t",1O:A.1O}).1E(a(A.4g=19.1r("1M")).1w({"1R":"8o"})).1E(a(A.2C=19.1r("1M")).1w({"1R":"6K"}))),a(A.V).3O("8p"+A.G.1C),A.G.8q&&A.2l(19.6n,"2u",a.1k(B(a){A.1A()&&(a=m.4M(a,".3m, .5x"),(!a||a&&a!=A.V&&a!=A.Q)&&A.1o())},A));P(1B.38.49&&A.G.2E){a(A.V).3O("5o");I b=A.V.8r;b.8s=A.G.2E+"4u",b.8t=A.G.2E+"4u",b.8u=A.G.2E+"4u",b.8v=A.G.2E+"4u"}A.6L(),A.21("1m",!0)}},5y:B(){a(A.V=19.1r("1M")).1w({"1R":"3m"})},4v:B(){A.1m();I a=t.14(A.Q);a?a.1m():(39 g(A.Q),A.21("3U",!0))},5z:B(){A.2l(A.Q,"3G",A.4w),A.2l(A.Q,"5d",a.1k(B(a){A.5p(a)},A)),A.G.2F&&a.17(A.G.2F,a.1k(B(b,c){I d=!1;c=="2u"&&(d=A.G.1N&&m.3X(A.G.1N,B(a){J a.Q=="3V"&&a.1Z=="2u"}),A.21("4F",d)),A.2l(A.Q,c,c=="2u"?d?A.2y:A.1F:a.1k(B(){A.6M()},A))},A)),A.G.1N&&a.17(A.G.1N,a.1k(B(b,c){I d;1n(c.Q){O"3V":P(A.1x("4F")&&c.1Z=="2u")J;d=A.Q;15;O"1h":d=A.1h}d&&A.2l(d,c.1Z,c.1Z=="2u"?A.1o:a.1k(B(){A.5q()},A))},A));I b=!1;!A.G.8w&&A.G.2F&&((b=a.6N("4s",A.G.2F)>-1)||a.6N("6O",A.G.2F)>-1)&&A.1h=="2m"&&A.2l(A.Q,b?"4s":"6O",B(a){A.1x("3U")&&A.L(a)})},6L:B(){A.2l(A.V,"3G",A.4w),A.2l(A.V,"5d",A.5p),A.2l(A.V,"3G",a.1k(A.1F,A)),A.G.1N&&a.17(A.G.1N,a.1k(B(b,c){I d;1n(c.Q){O"1b":d=A.V}d&&A.2l(d,c.1Z,c.1Z.2R(/^(2u|4s|3G)$/)?A.1o:a.1k(B(){A.5q()},A))},A))},1F:B(b){A.22("1o"),A.22("4x"),A.1A()||(A.21("1A",!0),A.G.1y?A.6P(b):A.1x("36")||A.3n(A.2P),A.1x("3U")&&A.L(b),A.4y(),A.G.4z&&m.4L(a.1k(B(){A.4w()},A)),a.11(A.G.4A)=="B"&&(!A.G.1y||A.G.1y&&A.G.1y.3M&&A.1x("36"))&&A.G.4A(A.2C.3J,A.Q),1B.38.49&&A.G.2E&&a(A.V).3O("6Q").6R("5o"))},1o:B(){A.22("1F"),A.1x("1A")&&(A.21("1A",!1),1B.38.49&&A.G.2E?(a(A.V).6R("6Q").3O("5o"),A.3P("4x",a.1k(A.5r,A),A.G.2E)):A.5r(),A.Y.25)&&(A.Y.25.6S(),A.Y.25=1g,A.21("25",!1))},5r:B(){A.1x("1m")&&(a(A.V).Z({E:"-4t",F:"-4t"}),w.6r(),A.6T(),a.11(A.G.6U)=="B"&&!A.2c)&&A.G.6U(A.2C.3J,A.Q)},2y:B(a){A[A.1A()?"1o":"1F"](a)},1A:B(){J A.1x("1A")},6M:B(b){A.22("1o"),A.22("4x"),!A.1x("1A")&&!A.5s("1F")&&A.3P("1F",a.1k(B(a){A.22("1F"),A.1F(a)},A,b),A.G.8x||1)},5q:B(){A.22("1F"),!A.5s("1o")&&A.1x("1A")&&A.3P("1o",a.1k(B(){A.22("1o"),A.22("4x"),A.1o()},A),A.G.8y||1)},21:B(a,b){A.Y.1V[a]=b},1x:B(a){J A.Y.1V[a]},4w:B(){A.21("3T",!0),A.1x("1A")&&A.4y(),A.G.4z&&A.22("5t")},5p:B(){A.21("3T",!1),A.G.4z&&A.3P("5t",a.1k(B(){A.22("5t"),A.1x("3T")||A.1o()},A),A.G.4z)},5s:B(a){J A.Y.2J[a]},3P:B(a,b,c){A.Y.2J[a]=m.4K(b,c)},22:B(a){A.Y.2J[a]&&(1q.6V(A.Y.2J[a]),8z A.Y.2J[a])},6W:B(){a.17(A.Y.2J,B(a,b){1q.6V(b)}),A.Y.2J=[]},2l:B(b,c,d,e){d=a.1k(d,e||A),A.Y.4E.1P({Q:b,6X:c,6Y:d}),a(b).3j(c,d)},6Z:B(){a.17(A.Y.4E,B(b,c){a(c.Q).8A(c.6X,c.6Y)})},3F:B(a){I b=t.14(A.Q);b&&b.3F(a)},6T:B(){A.3F(A.G.W.1b)},2o:B(){I a=t.14(A.Q);a&&(a.2o(),A.1A()&&A.L())},3n:B(b,c){I d=a.U({3Q:A.G.3Q},c||{});A.1m(),w.4i.3n(A,b),A.4v(),A.21("36",!0),d.3Q&&d.3Q(A.2C.3J,A.Q)},6P:B(b){A.1x("25")||A.G.1y.3M&&A.1x("36")||(A.21("25",!0),A.G.2c&&(A.2c?A.2c.70():(A.2c=A.71(A.G.2c),A.21("36",!1)),A.L(b)),A.Y.25&&(A.Y.25.6S(),A.Y.25=1g),A.Y.25=a.1y({8B:A.2P,11:A.G.1y.11,35:A.G.1y.35||{},72:A.G.1y.72||"5n",8C:a.1k(B(a){a.8D!==0&&(A.G.2c?A.2c?(A.2c.1f(),A.2c=1g):A.4v():A.4v(),A.3n(a.8E),A.21("25",!1),A.1x("1A")&&(A.L(),A.4y(),A.G.4A))&&A.G.4A(A.2C.3J,A.Q)},A)}))},71:B(b){I c=19.1r("1M"),b=2T.4a(c,a.U({},b||{})),e=2T.4Z(c);J a(c).Z(d(e)),A.3n(c,{3Q:!1}),b.70(),b},L:B(b){P(A.1A()){I c;P(A.G.1h=="2m"){c=w.27.5m(b);I d=w.27.4b;c?d.x||d.y?(A.Y.1Z={x:d.x,y:d.y},c=1g):c=b:(d.x||d.y?A.Y.1Z={x:d.x,y:d.y}:A.Y.1Z||(c=w.27.6J(A.Q),A.Y.1Z={x:c.E,y:c.F}),c=1g)}1K c=A.1h;w.27.6F(A,A.G.W.1b,c,A.G.W.1h);P(b&&w.27.5m(b)){I d=a(A.V).6B(),e=a(A.V).6C(),b=m.3Y(b);c=m.Q.43(A.V),b.x>=c.E&&b.x<=c.E+d&&b.y>=c.F&&b.y<=c.F+e&&m.4L(a.1k(B(){A.22("1o")},A))}}},4y:B(){P(A.1x("1m")&&!A.G.1O){I b=w.6q();b&&b!=A&&A.1O<=b.1O&&a(A.V).Z({1O:A.1O=b.1O+1})}},1f:B(){A.6Z(),A.6W(),t.1f(A.Q),A.1x("1m")&&A.V&&(a(A.V).1f(),A.V=1g);I b=a(A.Q).35("4D");b&&(a(A.Q).1w("4C",b),a(A.Q).35("4D",1g))}}}()),1B.5Q()})(3p)',62,537,'||||||||||||||||||||||||||||||||||||this|function||width|left|top|options|height|var|return|Math|position|lineTo|dimensions|case|if|element|border|background|stem|extend|container|hook|radius|_cache|css||type|shadow||get|break||each||document|closeButton|tooltip|color|offset|bubble|remove|null|target|ceil|opacity|proxy|max|build|switch|hide|length|window|createElement|horizontal|_hookPosition|bottom|right|attr|getState|ajax|for|visible|Tipped|skin|arc|append|show|beginPath|closePath|round|getTooltip|else|padding|div|hideOn|zIndex|push|90|class|anchor|getOrderLayout|_globalAlpha|states|G_vmlCanvasManager|vertical|tooltips|event|containment|setState|clearTimer||px|xhr|parseInt|Position|string|number|size|blurs|spinner||180|globalAlpha|fillStyle|hex2fill|getOrientation|abs|Skins|setEvent|mouse|isElement|refresh|fill|middle|center|closeButtonShadow|shadows|click|overlap|PI|blur|toggle|split|box|cleanup|contentElement|getSkin|fadeDuration|showOn|score|add|contentDimensions|timers|indexOf|canvas|moveTo|maxWidth|bubbleCanvas|content|call|match|scripts|Spinners|getContext|charAt|isCenter|toLowerCase|getLayout|diameter|layout|stemLayout|hookPosition|cornerOffset|constructor|data|updated|prototype|support|new|x1|y1|x2|y2|topleft|topright|righttop|lefttop|math|bind|Stem|defaultSkin|t_Tooltip|update|without|jQuery|getVisible|items|createFillStyle|positions|topmiddle|rightmiddle|rightbottom|bottomright|bottommiddle|bottomleft|leftbottom|leftmiddle|regex|getBorderDimensions|skins|setHookPosition|mouseenter|initElement|getStemLayout|firstChild|transition|boolean|cache|contained|addClass|setTimer|afterUpdate|000|startingZIndex|active|skinned|self|arguments|any|pointer|cumulativeScrollOffset|scrollTop|scrollLeft|parentNode|cumulativeOffset|Opera||required|available|pow|cssTransitions|create|mouseBuffer|getCenterBorderDimensions|cos|substring|prepare|skinElement|order|UpdateQueue|rotate|borderRadius|test|topcenter|rightcenter|bottomcenter|leftcenter|body|selector|mousemove|10000px|ms|_buildSkin|setActive|fadeTransition|raise|hideAfter|onShow|Object|title|tipped_restore_title|events|toggles|apply|try|catch|select|delay|defer|findElement|closest|Chrome|check|touch|hideAll|setDefaultSkin|setStartingZIndex|isVisibleByElement|undefined|isArray|isCorner|getSide|getDimensions|||getBubbleLayout|100|min|floor|hoverCloseButton|defaultCloseButton|auto|getMeasureElementDimensions|drawCloseButtonState|default|hover|mouseleave|_drawBackgroundPath|getBlurOpacity|stemCanvas|closeButtonCanvas|black|_remove|reset|CloseButtons|isPointerEvent|html|t_hidden|setIdle|hideDelayed|_hide|getTimer|idle|in|createOptions|getAttribute|tipped|_preBuild|createPreBuildObservers|Array|wrap|concat|_each|member|pageX|RegExp|IE|AppleWebKit|Gecko|replace|_|notified|alert|requires|createEvent|init|ready|startDelegating|drawRoundedRectangle|fillRect|drawPixelArray|Gradient|addColorStops|toOrientation|side|toDimension|atan|red|green|blue|getSaturatedBW|360|createHookCache|drawBubble|drawCloseButton|t_ContentContainer|first|25000px|t_Close|closeButtonShift|closeButtonMouseover|closeButtonMouseout|60060600006060606006|_drawBorderPath|backgroundRadius|setGlobalAlpha|sqrt|drawBackground|documentElement|getByTooltipElement|is|getHighestTooltip|resetZ|removeDetached|base|getInversedPosition|getTooltipPositionFromTarget|adjustOffsetBasedOnHooks|closeButtonSkin|flip|viewport|typeof|outerWidth|outerHeight|innerWidth|innerHeight|set|distance|targetOverlap|tooltipOverlap|getAbsoluteOffset|t_Content|createPostBuildObservers|showDelayed|inArray|touchmove|ajaxUpdate|t_visible|removeClass|abort|resetHookPosition|onHide|clearTimeout|clearTimers|eventName|handler|clearEvents|play|insertSpinner|dataType|_stemPosition|object|setAttribute|getElementById|slice|throw|nodeType|setTimeout|pageY|do|while|exec|parseFloat|attachEvent|MSIE|WebKit|KHTML|rv|MobileSafari|Apple|Mobile|Safari|navigator|userAgent|0_b1|Version|fn|jquery|substr|TouchEvent|WebKitTransitionEvent|TransitionEvent|OTransitionEvent|ExplorerCanvas|excanvas|js|createLinearGradient|addColorStop|spacing|0123456789abcdef|hex2rgb|rgba|join|255|hue|saturation|brightness|fff|init_|t_Bubble|find|15000px|t_CloseButtonShift|CloseButton|t_CloseState|translate|lineWidth|6660066660666660066|60060666006060606006|6660066660606060066|stemOffset|270|sin|setOpacity|getCenterBorderDimensions2|acos|t_Shadow|prepend|t_ShadowBubble|drawStem|t_ShadowStem|before|t_CloseButtonShadow|9999|touchstart|close|preventDefault|stopPropagation|getBySelector|move|t_UpdateQueue|t_clearfix|t_Content_|t_Skin|t_Tooltip_|hideOnClickOutside|style|MozTransitionDuration|webkitTransitionDuration|OTransitionDuration|transitionDuration|fixed|showDelay|hideDelay|delete|unbind|url|complete|status|responseText'.split('|'),0,{}));