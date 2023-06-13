/ / == ClosureCompiler ==
/ / @ Compilation_level SIMPLE_OPTIMIZATIONS

/ **
 * @ Licença jqGrid 4.5.4 - jQuery Grade
 * Copyright (c) 2008, Tony Tomov, tony@trirand.com
 * Dupla licenciado sob as licenças MIT e GPL
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
 * Data: 2013/10/06
 * /
/ / Opções jsHint
/ * Jshint mal: true, eqeqeq: false, eqnull: true, desenvolvi: true * /
/ * JQuery globais * /

(Function ($) {
"Use strict";
.. Jgrid $ = $ jgrid | | {};
$. Estender ($. Jgrid, {
	versão: "4.5.4",
	HtmlDecode: function (value) {
		if (valor && (valor === "" | | Valor === "" | | (value.length === 1 && value.charCodeAt (0) === 160))) { retornar "";}
		voltar! valor? valor:.... String (valor) replace (/> / g, ">") replace (/ </ g, "<") replace (/ "/ g '"') replace (/ & ;/ g, "&");		
	},
	HtmlEncode: function (value) {
		voltar! valor? valor:... String (valor) replace (/ & / g, "&") replace (/ \ "/ g", "") replace (/ </ g, "<") replace (/. > / g ",>");
	},
	formato: function (formato) {/ / jqgformat
		.. var args = $ MakeArray (argumentos) fatia (1);
		if (formato == null) {format = "";}
		voltar format.replace (/ \ {(\ d +) \} / g, function (m, i) {
			voltar args [i];
		});
	},
	msie: navigator.appName === 'Microsoft Internet Explorer',
	msiever: function () {
		var rv = -1;
		var ua = navigator.userAgent;
		var re = new RegExp ("MSIE ([0-9] {1,} [\ 0,0-9] {0,})");
		if (re.exec (ua)! = null) {
			rv = parseFloat (RegExp. $ 1);
		}
		voltar rv;
	},
	getCellIndex: function (celular) {
		var c = $ (celular);
		if (c.is ('tr')) {return 1;}
		c = (! c.is ('td') && c.is ('th') c.closest ("td, th"): c) [0];
		{. return $ inArray (c, c.parentNode.cells);} if (. $ jgrid.msie)
		voltar c.cellIndex;
	},
	stripHtml: function (v) {
		v = String (v);
		var regexp = / <("[^"] * "| '[^"] * | [^' ">]) *> / gi;
		se (v) {
			v = v.replace (regexp, "");
			retorno (v && v! == '' && v! == '')? v.replace (/ \ "/ g," '"):" ";
		} 
			retornar v;
	},
	stripPref: function (pref, id) {
		. var obj = $ tipo (pref);
		if (obj === "string" | | obj === "number") {
			pref = String (pref);
			id = pref! == ""? . String (id) substituir (String (pref) ","): id;
		}
		voltar id;
	},
	analisar: function (jsonString) {
		var js = jsonString;
		if (js.substr (0,9) === "while (1);") {js = js.substr (9);}
		if (js.substr (0,2) === "/ *") {js = js.substr (2, js.length-4);}
		if (js!) {js = "{}";}
		return ($. jgrid.useJSON === verdadeiro && typeof JSON === 'objeto' && typeof 'função' JSON.parse ===)?
			JSON.parse (js):
			eval ('(' + js + ')');
	},
	parseDate: function (formato, data, newFormat, opta) {
		símbolo var = / \ \ |. [dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU] / g,
		timezone = / \ b (: [PMCEA] [SDP] T | (: Pacific | Montanha | Central | Oriente | Atlântico) (: Padrão | Daylight | Prevalecendo) Tempo | (:? GMT | UTC) (?: [- +] \ d {4})) \ b / g,?
		timezoneClip = / [^ - + \ dA-Z] / g,
		msDateRegExp = new RegExp ("^ \ / Data \ \ (((? -) [0-9] + [+]) (([- +]) ([0-9] {2}) ([0-9 ] {2}))? \ \) \ / $ "),
		msMatch = ((data typeof === 'string') date.match (msDateRegExp): null),
		pad = function (value, comprimento) {
			valor = String (valor);
			comprimento = parseInt (comprimento, 10) | | 2;
			while (value.length <comprimento) {value = '0 '+ valor;}
			valor retorno;
		},
		ts = {m: 1, d: 1, y: 1970, h: 0, i: 0, s: 0, u: 0},
		timestamp = 0, MS, k, hl,
		h12to24 = function (ampm, h) {
			if (ampm === 0) {if (h === 12) {h = 0;}}
			else {if (h == 12!) {h + = 12;}}
			regressar h;
		};
		if (opta === indefinido) {
			opta = $ jgrid.formatter.date.;
		}
		/ / arquivos antigos lang
		if (opts.parseRe === indefinido) {
			opts.parseRe = / [Tt \ \ \ /:. _;, \ t \ s-] /;
		}
		if (opts.masks.hasOwnProperty (formato)) {format = opts.masks [formato];}
		if (data && data! = null) {
			if (isNaN (data -. 0) && String (formato) toLowerCase () === "u") {
				/ / Timestamp Unix
				timestamp = new Date (parseFloat (data) * 1000);
			} Else if (date.constructor === Data) {
				timestamp = data;
				Suporte ao formato de data / / Microsoft
			} Else if (msMatch! == Null) {
				timestamp = new Date (parseInt (msMatch [1], 10));
				if (msMatch [3]) {
					compensar var = Number (msMatch [5]) * 60 + Number (msMatch [6]);
					(? (msMatch [4] === '-') 1: -1) compensada * =;
					offset - = timestamp.getTimezoneOffset ();
					timestamp.setTime (Number (Número (timestamp) + (offset * 60 * 1000)));
				}
			} Else {
				... date = String (data) replace (/ \ \ T / g, "T") replace (/ \ \ t /, "t") split (opts.parseRe);
				.. format = format.replace (/ \ \ T / g, "T") replace (/ \ \ t /, "t") split (opts.parseRe);
				/ / Para analisar os nomes dos meses
				for (k = 0, hl = format.length; k <hl; k + +) {
					if (formato [k] === 'M') {
						. dM = $ inArray (data [k], opts.monthNames);
						if (dM == -1 && dM <12!) {data [k] = dM +1; ts.m = data [k];}
					}
					if (formato [k] === 'F') {
						. dM = $ inArray (data [k], opts.monthNames, 12);
						if (! dM == -1 && dM> 11) {data [k] = dM 1-12; ts.m = data [k];}
					}
					if (formato [k] === 'a') {
						. dM = $ inArray (data [k], opts.AmPm);
						if (dM! == -1 && dM <2 && data [k] === opts.AmPm [DM]) {
							data [k] = dM;
							ts.h = h12to24 (data [k], ts.h);
						}
					}
					if (formato [k] === 'A') {
						. dM = $ inArray (data [k], opts.AmPm);
						if (dM! == -1 && dM> 1 && data [k] === opts.AmPm [DM]) {
							data [k] = DM-2;
							ts.h = h12to24 (data [k], ts.h);
						}
					}
					if (formato [k] === 'g') {
						ts.h = parselnt (data [k], 10);
					}
					if (data [k]! == indefinido) {
						ts [. formato [k] toLowerCase ()] = parselnt (data [k], 10);
					}
				}
				if (ts.f) {ts.m = ts.f;}
				if (ts.m === 0 && ts.y === 0 && ts.d === 0) {
					retornar "";
				}
				ts.m = parselnt (ts.m, 10) -1;
				var ty = ts.y;
				if (ty> = 70 && ty <= 99) {ts.y = 1,900 + ts.y;}
				else if (ty> = 0 && ty <= 69) {ts.y = 2000 + ts.y;}
				timestamp = new Date (ts.y, ts.m, ts.d, ts.h, ts.i, ts.s, ts.u);
			}
		} Else {
			timestamp = new Date (ts.y, ts.m, ts.d, ts.h, ts.i, ts.s, ts.u);
		}
		if (newFormat === indefinido) {
			voltar timestamp;
		}
		if (opts.masks.hasOwnProperty (newFormat)) {
			newFormat = opts.masks [newFormat];
		} Else if (newFormat!) {
			newFormat = 'Ym-d';
		}
		var 
			L = timestamp.getHours (),
			i = timestamp.getMinutes (),
			j = timestamp.getDate (),
			n = timestamp.getMonth () + 1,
			o = timestamp.getTimezoneOffset (),
			s = timestamp.getSeconds (),
			u = timestamp.getMilliseconds ()
			w = timestamp.getDay (),
			Y = timestamp.getFullYear (),
			N = (w + 6)% 7 + 1,
			z = (new Date (Y, n - 1, j) - new Date (Y, 0, 1)) / 86400000,
			bandeiras = {
				/ / Dia
				d: pad (j),
				D: opts.dayNames [w],
				j: j,
				l: opts.dayNames [w + 7]
				N: N,
				S: opts.S (j),
				/ / J <11 | | j> 13? ['Rua', 'nd', 'rd', 'th'] [Math.min ((j - 1)% 10, 3)]: 'th',
				w: w,
				z: z,
				/ / Semana
				W: N <5? Math.floor ((z + N - 1) / 7) + 1:. Math.floor ((z + N - 1) / 7) | | ((novo Data (Y - 1, 0, 1) getDay () + 6)% 7 <4 53: 52),
				/ / Mês
				F: opts.monthNames [n - 1 + 12],
				m: pad (n),
				M: opts.monthNames [n - 1],
				n: n,
				t: '?',
				/ / Ano
				L: '?',
				o: '?',
				Y: Y,
				y:. String (Y) substring (2),
				/ / Hora
				um: L <12? opts.AmPm [0]: opts.AmPm [1],
				A: G <12? opts.AmPm [2]: opts.AmPm [3],
				B: '?',
				g: G% 12 | | 12
				G: G,
				h: pad (G% 12 | | 12),
				H: pad (G),
				i: pad (i),
				s: Almofada (s),
				u: u,
				/ / Fuso horário
				e:, '?'
				I: '?',
				O: (o> 0 "-":? "+") + Almofada (Math.floor (Math.abs (O) / 60) * 100 + Math.abs (o) 60%, 4),
				P: '?',
				T: (. String (timestamp) jogo (fuso horário) | | [""].). Pop () substituir (timezoneClip, ""),
				Z: '?',
				/ / Full Data / Hora
				c: '?',
				r: '?',
				U: Math.floor (timestamp / 1000)
			};
		voltar newformat.replace (forma, função ($ 0) {
			voltar flags.hasOwnProperty ($ 0)? flags [$ 0]: $ 0.substring (1);
		});
	},
	jqID: function (sid) {
		. retornar String (sid), replace (/ [". # $% & '() * +, \ /:;? <=> @ \ [\ \ \] \ ^` {|} ~] / g, " \ \ $ & ");
	},
	orientação: 1,
	uidPref: 'JQG',
	randId: function (prefixo) {
		retorno (prefixo | | $ jgrid.uidPref.) + ($ jgrid.guid + +.);
	},
	getAccessor: function (obj, expr) {
		var ret, p, prm = [], i;
		if (typeof expr === 'função') {return expr (obj);}
		ret = obj [expr];
		if (ret === indefinido) {
			try {
				if (typeof expr === 'string') {
					prm = expr.split ('.');
				}
				i = prm.length;
				if (i) {
					ret = obj;
					while (ret && i -) {
						p = prm.shift ();
						ret = ret [p];
					}
				}
			} Catch (e) {}
		}
		voltar ret;
	},
	getXmlData: function (obj, expr, returnObj) {
		var ret, m = typeof expr === 'string'? expr.match (/ ^ (*) \ [(\ w +) \] $ /).: ​​null;
		if (typeof expr === 'função') {return expr (obj);}
		if (m && m [2]) {
			/ / M [2] é o seletor de atributo
			/ / M [1] é um seletor de elemento opcional
			/ / exemplos: "[id]", "linhas [página]"
			retorno m [1]? . $ (M [1], obj) attr (m) [2]:. $ (Obj) attr (m [2]);
		}
			ret = $ (expr, obj);
			if (returnObj) {ret return;}
			. / / $ (Expr, obj) filtro (': último') / / usamos ': último "a ser mais compatível com a versão antiga do jqGrid
			retornar ret.length> 0? $ (Ret) text (): undefined,.
	},
	cellWidth: function () {
		var $ testDiv = $ (<div class='ui-jqgrid' style='left:10000px'> <table class='ui-jqgrid-btable' style='width:5px;'> <tr class = 'jqgrow " '> <td style='width:5px;display:block;'> </ td> </ tr> </ table> </ div> "),
		testCell = $ testDiv.appendTo ("corpo")
			. Encontrar ("td")
			. Largura ();
		TestDiv.remove $ ();
		retornar Math.abs (testCell-5)> 0,1;
	},
	cell_width: true,
	AjaxOptions: {},
	a partir de: function (fonte) {
		/ / Original Autor Hugo Bonacci
		/ / Licença MIT http://jlinq.codeplex.com/license
		var QueryObject = function (d, q) {
		if (typeof d === "string") {
			d = $ dados (d).;
		}
		var self = isso,
		_data = d,
		_usecase = true,
		_trim = false,
		_query = q,
		_stripNum = / [\ $,%] / g,
		_lastCommand = null,
		_lastField = null,
		_orDepth = 0,
		_negate = false,
		_queuedOperator = "",
		_sorting = [],
		_useProperties = true;
		if (typeof d === "objeto" && d.push) {
			if (d.length> 0) {
				if (typeof d [0]! == "objeto") {
					_useProperties = false;
				} Else {
					_useProperties = true;
				}
			}
		} Else {
			jogar "dados fornece não é uma matriz";
		}
		this._hasData = function () {
			? retornar _data === nula falsa: _data.length === 0 false: true;
		};
		this._getStr = function (s) {
			var frase = [];
			if (_trim) {
				phrase.push ("jQuery.trim (");
			}
			phrase.push ("String (" + s + ")");
			if (_trim) {
				phrase.push (")");
			}
			if (! _usecase) {
				phrase.push (". toLowerCase ()");
			}
			retornar phrase.join ("");
		};
		this._strComp = function (val) {
			if (val typeof === "string") {
				. "toString ()" retornar;
			}
			retornar "";
		};
		this._group = function (f, u) {
			voltar ({campo: f.toString (), única: u, itens: []});
		};
		this._toStr = function (frase) {
			if (_trim) {
				frase = $ trim (frase).;
			}
			frase = phrase.toString () replace (/ \ \ / g, '\ \ \ \') replace (/ \ "/ g, '\ \"')..;
			voltar _usecase? frase: phrase.toLowerCase ();
		};
		this._funcLoop = function (func) {
			Resultados var = [];
			$. Cada (_data, function (i, v) {
				results.push (func (v));
			});
			retornar resultados;
		};
		this._append = function (s) {
			var i;
			if (_query === null) {
				_query = "";
			} Else {
				_query + = _queuedOperator === ""? "&&": _queuedOperator;
			}
			for (i = 0; i <_orDepth; i + +) {
				_query + = "(";
			}
			if (_negate) {
				"!" _query + =;
			}
			_query + = "(" + s + ")";
			_negate = false;
			_queuedOperator = "";
			_orDepth = 0;
		};
		this._setCommand = function (f, c) {
			_lastCommand = f;
			_lastField = c;
		};
		this._resetNegate = function () {
			_negate = false;
		};
		this._repeatCommand = function (f, v) {
			if (_lastCommand === null) {
				retornar auto;
			}
			if (f! == null && v! == null) {
				retornar _lastCommand (f, v);
			}
			if (_lastField === null) {
				retornar _lastCommand (f);
			}
			if (!) {_useProperties
				retornar _lastCommand (f);
			}
			retornar _lastCommand (_lastField, f);
		};
		this._equals = function (a, b) {
			retorno (self._compare (a, b, 1) === 0);
		};
		this._compare = function (a, b, d) {
			var toString = Object.prototype.toString;
			if (d === indefinido) {d = 1;}
			if (a === indefinido) {a = null;}
			if (b === indefinido) {b = null;}
			if (a === nulo b && === null) {
				return 0;
			}
			if (a === nulo && b! == null) {
				retornar 1;
			}
			if (a! == null && b === null) {
				retornar -1;
			}
			if (toString.call (a) === '[objeto Data]' && toString.call (b) === '[objeto Data]') {
				se (a <b) {return-d;}
				if (a> b) {return d;}
				return 0;
			}
			if (typeof _usecase && a == "número"! && b typeof! == "number") {
				a = String (a);
				b = String (b);
			}
			se (a <b) {return-d;}
			if (a> b) {return d;}
			return 0;
		};
		this._performSort = function () {
			if (_sorting.length === 0) {return;}
			_data = self._doSort (_data, 0);
		};
		this._doSort = function (d, q) {
			var por = _sorting [q]. pela,
			dir = _sorting [q]. dir,
			type = _sorting [q]. Tipo,
			dfmt = _sorting [q] DATEFMT.;
			if (q === _sorting.length-1) {
				voltar self._getOrder (d, por, dir, tipo, dfmt);
			}
			q + +;
			valores var = self._getGroup (d, por, dir, tipo, dfmt), os resultados = [], i, j, classificado;
			for (i = 0; i <values.length; i + +) {
				classificadas = self._doSort (valores [i] itens, q.);
				for (j = 0; j <sorted.length; j + +) {
					results.push (classificado [j]);
				}
			}
			retornar resultados;
		};
		this._getOrder = function (dados, por, dir, tipo, dfmt) {
			var sortData = [], _sortData = [], newdir = dir === "a"? 1: -1, i, ab, j,
			findSortKey;

			if (tipo === indefinido) {type = "text";}
			if (tipo === 'float' | | tipo === 'número' | | === tipo "moeda" | | === tipo 'numérico') {
				findSortKey = function ($ celular) {
					chave var = parseFloat (String ($ celular) substituir (_stripNum,'').);
					voltar isNaN (key)? 0.00: chave;
				};
			} Else if (tipo === 'int' | | === tipo 'inteiro') {
				findSortKey = function ($ celular) {
					return $ celular? parseFloat (. String ($ celular) substituir (_stripNum,'')): 0;
				};
			} Else if (tipo === 'date' | | tipo === 'datetime') {
				findSortKey = function ($ celular) {
					.. return $ jgrid.parseDate (dfmt, $ celular) getTime ();
				};
			} Else if ($. IsFunction (tipo)) {
				findSortKey = tipo;
			} Else {
				findSortKey = function ($ celular) {
					$ Célula = $ celular? . $ Trim (String ($ celular)): "";
					voltar _usecase? $ Celular: $ cell.toLowerCase ();
				};
			}
			$. Cada (dados, função (i, v) {
				ab = por! == ""? . $ Jgrid.getAccessor (v, por): v;
				if (ab === indefinido) {ab = "";}
				ab = findSortKey (ab, v);
				_sortData.push ({'vSort': ab, 'index': i});
			});

			_sortData.sort (function (a, b) {
				a = a.vSort;
				b = b.vSort;
				retornar self._compare (a, b, NEWDIR);
			});
			j = 0;
			var NREC = data.length;
			/ / Em cima, mas nós não alterar os dados originais.
			enquanto (j <NREC) {
				i = _sortData [j] índice.;
				sortData.push (dados [i]);
				j + +;
			}
			voltar sortData;
		};
		this._getGroup = function (dados, por, dir, tipo, dfmt) {
			Resultados var = [],
			group = null,
			última = null, val;
			$. Cada (self._getOrder (dados, por, dir, tipo, dfmt), função (i, v) {
				val = $ jgrid.getAccessor (v, por).;
				if (val == null) {val = "";}
				if (! self._equals (último, val)) {
					last = val;
					if (grupo! == null) {
						results.push (grupo);
					}
					group = self._group (por, val);
				}
				group.items.push (v);
			});
			if (grupo! == null) {
				results.push (grupo);
			}
			retornar resultados;
		};
		this.ignoreCase = function () {
			_usecase = false;
			retornar auto;
		};
		this.useCase = function () {
			_usecase = true;
			retornar auto;
		};
		this.trim = function () {
			_trim = true;
			retornar auto;
		};
		this.noTrim = function () {
			_trim = false;
			retornar auto;
		};
		this.execute = function () {
			var match = _query, resultados = [];
			if (jogo === null) {
				retornar auto;
			}
			$. Cada (_data, function () {
				if (eval (jogo)) {results.push (this);}
			});
			_DATA = resultados;
			retornar auto;
		};
		this.data = function () {
			voltar _data;
		};
		this.select = function (f) {
			self._performSort ();
			if (! self._hasData ()) {return [];}
			self.execute ();
			if ($. isFunction (f)) {
				Resultados var = [];
				$. Cada (_data, function (i, v) {
					results.push (f (v));
				});
				retornar resultados;
			}
			voltar _data;
		};
		this.hasMatch = function () {
			if (! self._hasData ()) {return false;}
			self.execute ();
			retornar _data.length> 0;
		};
		this.andNot = function (f, v, x) {
			! _negate = _negate;
			retornar self.and (f, v, x);
		};
		this.orNot = function (f, v, x) {
			! _negate = _negate;
			retornar self.or (f, v, x);
		};
		this.not = function (f, v, x) {
			retornar self.andNot (f, v, x);
		};
		this.and = function (f, v, x) {
			_queuedOperator = "&&";
			if (f === indefinido) {
				retornar auto;
			}
			retornar self._repeatCommand (f, v, x);
		};
		this.or = function (f, v, x) {
			_queuedOperator = "| |";
			if (f === indefinido) {return auto;}
			retornar self._repeatCommand (f, v, x);
		};
		this.orBegin = function () {
			_orDepth + +;
			retornar auto;
		};
		this.orEnd = function () {
			if (_query! == null) {
				_query + = ")";
			}
			retornar auto;
		};
		this.isNot = function (f) {
			! _negate = _negate;
			retornam self.is (f);
		};
		this.is = function (f) {
			self._append (+ f 'isso.');
			self._resetNegate ();
			retornar auto;
		};
		this._compareValues ​​= function (função, f, v, como, t) {
			var fld;
			if () {_useProperties
				fld = 'jQuery.jgrid.getAccessor (este, \'' + f +' \ ')';
			} Else {
				fld = "isto";
			}
			if (v === indefinido) {v = null;}
			/ / Var val = v === nulo f: v,
			var val = v,
			swst = t.stype === indefinido? "Text": t.stype;
			if (v! == null) {
			switch (swst) {
				caso 'int':
				case 'inteiro':
					val = (isNaN (Number (val)) | | val === "")? '0 ': Val / / Para ser corrigido com mais de código inteligente
					fld = 'parseInt (' + fld + ', 10)';
					val = 'parseInt ("+ val +', 10) ';
					break;
				caso 'float':
				caso "número":
				case 'numérico':
					. val = String (val) substituir (_stripNum,'');
					val = (isNaN (Number (val)) | | val === "")? '0 ': Val / / Para ser corrigido com mais de código inteligente
					fld = 'parseFloat (' + fld + ')';
					val = 'parseFloat (' + val + ')';
					break;
				caso 'date':
				case 'datetime':
					val = String (. $ jgrid.parseDate (t.newfmt | | 'Ym-d', val) getTime ().);
					fld = 'jQuery.jgrid.parseDate ("' + t.srcfmt + '",' + fld + ') getTime ().';
					break;
				default:
					fld = self._getStr (FLD);
					val = self._getStr ('"' + self._toStr (val) + '"');
			}
			}
			self._append (FLD + '' + como + '' + val);
			self._setCommand (func, f);
			self._resetNegate ();
			retornar auto;
		};
		this.equals = function (f, v, t) {
			retornam self._compareValues ​​(self.equals, f, v, "==", t);
		};
		this.notEquals = function (f, v, t) {
			retornar self._compareValues ​​("! ==" self.equals, f, v,, t);
		};
		this.isNull = function (f, v, t) {
			retornam self._compareValues ​​(self.equals, f, nulo, "===", t);
		};
		this.greater = function (f, v, t) {
			retornar self._compareValues ​​(self.greater, f, v, ">", t);
		};
		this.less = function (f, v, t) {
			retornar self._compareValues ​​(self.less, f, v, "<", t);
		};
		this.greaterOrEquals = function (f, v, t) {
			retornar self._compareValues ​​(self.greaterOrEquals, f, v, "> =", t);
		};
		this.lessOrEquals = function (f, v, t) {
			retornam self._compareValues ​​(self.lessOrEquals, f, v, "<=", t);
		};
		this.startsWith = function (f, v) {
			var val = (v == null)? f: v,
			comprimento = _trim? .. $ Trim (val.toString ()) comprimento: val.toString () comprimento;.
			if () {_useProperties
				self._append (self._getStr ('jQuery.jgrid.getAccessor (este, \'' + f +' \ ')') + '. substr (0,' + comprimento + ') ==' + self._getStr ('" '+ self._toStr (v) +' "'));
			} Else {
				?.. comprimento = _trim $ trim (v.toString ()) comprimento: v.toString () comprimento;.
				self._append (self._getStr ("isto") + '. substr (0,' + comprimento + ') ==' + self._getStr ('"' + self._toStr (f) + '"'));
			}
			self._setCommand (self.startsWith, f);
			self._resetNegate ();
			retornar auto;
		};
		this.endsWith = function (f, v) {
			var val = (v == null)? f: v,
			comprimento = _trim? .. $ Trim (val.toString ()) comprimento: val.toString () comprimento;.
			if () {_useProperties
				self._append(self._getStr('jQuery.jgrid.getAccessor(this,\''+f+'\')')+'.substr('+self._getStr('jQuery.jgrid.getAccessor(this,\''+f+'\')')+'.length-'+length+','+length+') == "'+ Self._toStr (v) +'" ');
			} Else {
				self._append(self._getStr('this')+'.substr('+self._getStr('this')+'.length-"'+self._toStr(f)+'".length,"'+self._toStr(f)+'".length) == "'+ Self._toStr (f) +'" ');
			}
			self._setCommand (self.endsWith, f); self._resetNegate ();
			retornar auto;
		};
		this.contains = function (f, v) {
			if () {_useProperties
				self._append(self._getStr('jQuery.jgrid.getAccessor(this,\''+f+'\')')+'.indexOf("'+self._toStr(v)+'",0) > -1 ');
			} Else {
				self._append (self._getStr ("isto") + "" + self._toStr (f) + '", 0)> -1' indexOf (. ');
			}
			self._setCommand (self.contains, f);
			self._resetNegate ();
			retornar auto;
		};
		this.groupBy = function (por, dir, tipo, DATEFMT) {
			if (self._hasData! ()) {
				return null;
			}
			voltar self._getGroup (_data, por, dir, tipo, DATEFMT);
		};
		this.orderBy = function (por, dir, stype, dfmt) {
			dir = dir == null? . "A": $ trim (. Dir.toString () toLowerCase ());
			if (stype == null) {stype = "text";}
			if (dfmt == null) {dfmt = "Ymd";}
			if (dir === "desc" | | dir === "descendente") {dir = "d";}
			if (dir === "asc" | | dir === "ascendente") {dir = "a";}
			_sorting.push ({by: by, dir: dir, digite: stype, DATEFMT: dfmt});
			retornar auto;
		};
		retornar auto;
		};
	return new QueryObject (fonte, null);
	},
	getMethod: function (nome) {
        voltar this.getAccessor ($ fn.jqGrid, nome.);
	},
	estender: function () {métodos
		. $ Estender ($ fn.jqGrid, métodos.);
		if (this.no_legacy_api!) {
			. $ Fn.extend (métodos);
		}
	}
});

$. Fn.jqGrid = function (pin) {
	if (typeof pin === 'string') {
		. var fn = $ jgrid.getMethod (pino);
		if (fn!) {
			jogar ("jqGrid - Inexistência método:" + pino);
		}
		.. var args = $ MakeArray (argumentos) fatia (1);
		voltar fn.apply (este, args);
	}
	voltar this.each (function () {
		if (this.grid) {return;}

		var p = $. estender (true, {
			url: "",
			height: 150,
			página: 1,
			rowNum: 20,
			rowTotal: null,
			registros: 0,
			pager: "",
			pgbuttons: verdadeiro,
			pginput: true,
			colModel: [],
			ROWLIST: [],
			COLNAMES: [],
			sortorder: "asc",
			SortName: "",
			datatype: "xml",
			mtype: "GET",
			altRows: false,
			selarrrow: [],
			savedRow: [],
			ShrinkToFit: true,
			xmlReader: {},
			jsonReader: {},
			subgrid: false,
			subGridModel: [],
			reccount: 0,
			lastpage: 0,
			lastsort: 0,
			selrow: null,
			beforeSelectRow: null,
			onSelectRow: null,
			onSortCol: null,
			ondblClickRow: null,
			onRightClickRow: null,
			onPaging: null,
			onSelectAll: null,
			onInitGrid: null,
			LoadComplete: null,
			gridComplete: null,
			LoadError: null,
			loadBeforeSend: null,
			afterInsertRow: null,
			beforeRequest: null,
			beforeProcessing: null,
			onHeaderClick: null,
			viewrecords: false,
			loadonce: false,
			multiselect: false,
			multikey: false,
			editurl: null,
			Pesquisa: false,
			legenda: "",
			hidegrid: true,
			hiddengrid: false,
			postData: {},
			userData: {},
			TreeGrid: false,
			treeGridModel: 'aninhado',
			treeReader: {},
			treeANode: -1,
			ExpandColumn: null,
			tree_root_level: 0,
			prmNames: {page: "page", linhas: "Linhas", tipo: "sidx", a ordem: "sord", de buscas: "_search", nd: "nd", id: "id", opera: "operar" , editoper: "editar", addoper: "add", deloper: "del", subgridid: "id", npágina: null, totalrows: "totalrows"},
			forceFit: false,
			gridstate: "visível",
			cellEdit: false,
			cellsubmit: "remota",
			nv: 0,
			loadui: "enable",
			barra de ferramentas: [falso, ""],
			rolar: false,
			multiboxonly: false,
			deselectAfterSort: true,
			scrollrows: false,
			LARGURA: false,
			scrollOffset: 18,
			cellLayout: 5,
			subGridWidth: 20,
			multiselectWidth: 20,
			gridview: false,
			rownumWidth: 25,
			rownumbers: false,
			pagerpos: 'Center',
			recordpos: "direito",
			FooterRow: false,
			userDataOnFooter: false,
			hoverrows: true,
			altclass: 'ui-priority-secundário ",
			viewsortcols: [falsos, 'vertical', true],
			resizeclass:'',
			autoencode: false,
			remapColumns: [],
			ajaxGridOptions: {},
			direção: "ltr",
			toppager: false,
			headertitles: false,
			scrollTimeout: 40,
			Dados: [],
			_index: {},
			agrupamento: false,
			groupingView: {groupField: [], groupOrder: [], GroupText: [], groupColumnShow: [], groupSummary: [], showSummaryOnHide: false, SortItems: [], sortnames: [], o resumo: [], summaryval: [ ], plusicon: "ui-icon-circlesmall-plus ', minusicon:" ui-icon-circlesmall-menos', displayField: []},
			ignoreCase: false,
			cmTemplate: {},
			idPrefix: "",
			MULTISORT: false
		}, $ Jgrid.defaults, pin | | {}).;
		ts = var isso, grade = {
			cabeçalhos: [],
			cols: [],
			rodapés: [],
			dragStart: function (i, x, y) {
				. var gridLeftPos = $ (this.bDiv) offset () esquerda.;
				this.resizing = {idx: i, startx: x.clientX, Sol: x.clientX - gridLeftPos};
				this.hDiv.style.cursor = "col-resize";
				this.curGbox = $ (.. "# rs_m" + $ jgrid.jqID (p.id), "# gbox_" + $ jgrid.jqID (p.id));
				this.curGbox.css ({display: "block", esquerda: x.clientX-gridLeftPos, top: y [1], altura: y [2]});
				$ (Ts) triggerHandler ("jqGridResizeStart", [x, i]).;
				if ($ isFunction (p.resizeStart).) {p.resizeStart.call (ts, x, i);}
				document.onselectstart = function () {return false;};
			},
			DragMove: function (x) {
				if (this.resizing) {
					var diff = x.clientX-this.resizing.startX,
					h = this.headers [this.resizing.idx],
					NewWidth = p.direction === "ltr"? h.width + dif: h.width - diff, hn, NWN;
					if (NewWidth> 33) {
						this.curGbox.css ({left: this.resizing.sOL + dif});
						if (p.forceFit === true) {
							hn = this.headers [this.resizing.idx + p.nv];
							NWN = p.direction === "ltr"? hn.width - diff: hn.width + dif;
							if (NWN> 33) {
								h.newWidth = NewWidth;
								hn.newWidth = NWN;
							}
						} Else {
							this.newWidth = p.direction === "ltr"? p.tblwidth + dif: p.tblwidth-diff;
							h.newWidth = NewWidth;
						}
					}
				}
			},
			dragend: function () {
				this.hDiv.style.cursor = "default";
				if (this.resizing) {
					var idx = this.resizing.idx,
					nw = this.headers [idx] NewWidth | | this.headers [idx] largura..;
					nw = parseInt (nw, 10);
					this.resizing = false;
					(". # Rs_m" + $ jgrid.jqID (p.id)). $ Css ("display", "none");
					p.colModel [idx] width = nw.;
					this.headers [idx] width = nw.;
					. this.headers [idx] el.style.width = nw + "px";
					. this.cols [idx] style.width = nw + "px";
					if (this.footers.length> 0) {. this.footers [idx] style.width = nw + "px";}
					if (p.forceFit === true) {
						nw = this.headers [idx + p.nv] NewWidth | | this.headers [idx + p.nv] largura..;
						. this.headers [idx + p.nv] width = nw;
						. this.headers [idx + p.nv] el.style.width = nw + "px";
						. this.cols [idx + p.nv] style.width = nw + "px";
						if (this.footers.length> 0) {this.footers [idx + p.nv] style.width = nw + "px";.}
						. p.colModel [idx + p.nv] width = nw;
					} Else {
						p.tblwidth = this.newWidth | | p.tblwidth;
						$ ('Table: first', this.bDiv). Css ("width", p.tblwidth + "px");
						$ ('Table: first', this.hDiv). Css ("width", p.tblwidth + "px");
						this.hDiv.scrollLeft = this.bDiv.scrollLeft;
						if (p.footerrow) {
							$ ('Table: first', this.sDiv). Css ("width", p.tblwidth + "px");
							this.sDiv.scrollLeft = this.bDiv.scrollLeft;
						}
					}
					. $ (Ts) triggerHandler ("jqGridResizeStop" [nw, idx]);
					if ($ isFunction (p.resizeStop).) {p.resizeStop.call (ts, nw, idx);}
				}
				this.curGbox = null;
				document.onselectstart = function () {return true;};
			},
			populateVisible: function () {
				if (grid.timer) {clearTimeout (grid.timer);}
				grid.timer = null;
				. var dh = $ (grid.bDiv) Altura ();
				if (dh!) {return;}
				mesa var = $ ("table: em primeiro lugar", grid.bDiv);
				linhas var, rh;
				if (tabela [0]. rows.length) {
					try {
						linhas = tabela [0] linhas [1].;
						rh = linhas? . $ (linhas) outerHeight () | | grid.prevRowHeight: grid.prevRowHeight;
					} Catch (pv) {
						rh = grid.prevRowHeight;
					}
				}
				Se {return;} (rh!)
				grid.prevRowHeight = rh;
				var rn = p.rowNum;
				var scrollTop = grid.scrollTop = grid.bDiv.scrollTop;
				var ttop = Math.round (. table.position () superior) - scrollTop;
				var TBot = ttop + table.height ();
				var div = rh * rn;
				página var, npágina, vazio;
				if (TBot <dh && ttop <= 0 &&
					(P.lastpage === indefinido | | parseInt ((TBot + + scrollTop div - 1) / div, 10) <= p.lastpage))
				{
					npágina = parseInt ((dh - TBot + div - 1) / div, 10);
					if (TBot> = 0 | | npágina <2 | | p.scroll === true) {
						page = Math.round ((TBot + scrollTop) / div) + 1;
						ttop = -1;
					} Else {
						ttop = 1;
					}
				}
				if (ttop> 0) {
					page = parseInt (scrollTop / div, 10) + 1;
					npágina = parseInt ((scrollTop + dh) / div, 10) + 2 - página;
					vazio = true;
				}
				if (npágina) {
					if (p.lastpage && (Página> p.lastpage | | p.lastpage === 1 | | (página === página p.page && === p.lastpage))) {
						retorno;
					}
					if (grid.hDiv.loading) {
						grid.timer = setTimeout (grid.populateVisible, p.scrollTimeout);
					} Else {
						p.page = página;
						if (vazio) {
							grid.selectionPreserver (tabela [0]);
							grid.emptyRows.call (tabela [0], false, false);
						}
						grid.populate (npágina);
					}
				}
			},
			scrollGrid: function (e) {
				if (p.scroll) {
					var scrollTop = grid.bDiv.scrollTop;
					if (grid.scrollTop === indefinido) {grid.scrollTop = 0;}
					if (scrollTop! == grid.scrollTop) {
						grid.scrollTop = scrollTop;
						if (grid.timer) {clearTimeout (grid.timer);}
						grid.timer = setTimeout (grid.populateVisible, p.scrollTimeout);
					}
				}
				grid.hDiv.scrollLeft = grid.bDiv.scrollLeft;
				if (p.footerrow) {
					grid.sDiv.scrollLeft = grid.bDiv.scrollLeft;
				}
				se (e) {e.stopPropagation ();}
			},
			selectionPreserver: function (ts) {
				var p = ts.p,
				sr = p.selrow, sra = p.selarrrow? . $ MakeArray (p.selarrrow): null,
				esquerda = ts.grid.bDiv.scrollLeft,
				restoreSelection = function () {
					var i;
					p.selrow = null;
					p.selarrrow = [];
					if (p.multiselect && sra && sra.length> 0) {
						for (i = 0; i <sra.length; i + +) {
							if (sra [i]! == sr) {
								. $ (Ts) jqGrid ("setSelection", sra [i], false, null);
							}
						}
					}
					if (sr) {
						. $ (Ts) jqGrid ("setSelection", sr, false, null);
					}
					ts.grid.bDiv.scrollLeft = left;
					. $ (Ts) desvincular ('selectionPreserver., RestoreSelection);
				};
				. $ (Ts) bind ('jqGridGridComplete.selectionPreserver', restoreSelection);				
			}
		};
		if (this.tagName.toUpperCase ()! == 'TABLE') {
			alert ("O elemento não é uma tabela");
			retorno;
		}
		if (document.documentMode! == indefinido) {/ / IE só
			if (document.documentMode <= 5) {
				alerta ("grade não pode ser usado no presente ('peculiaridades') Modo!");
				retorno;
			}
		}
		.. $ (This) empty () attr ("tabindex", "0");
		this.p = p;
		!. this.p.useProp = $ fn.prop;
		var i, dir;
		if (this.p.colNames.length === 0) {
			for (i = 0; i <this.p.colModel.length; i + +) {
				. this.p.colNames [i] = this.p.colModel [i] rótulo | | this.p.colModel [i] nome.;
			}
		}
		if (this.p.colNames.length! == this.p.colModel.length) {
			alert (. $ jgrid.errors.model);
			retorno;
		}
		var gv = $ ("<div class='ui-jqgrid-view'> </ div>"),
		. isMSIE = $ jgrid.msie;
		. ts.p.direction = $ trim (ts.p.direction.toLowerCase ());
		Se {ts.p.direction = "l";} ($ inArray (ts.p.direction, ["ltr", "RTL"]) === -1.)
		dir = ts.p.direction;

		. $ (Gv) insertBefore (this);
		$ (This) removeClass ("scroll") appendTo (gv)..;
		var por exemplo = $ ("<div class='ui-jqgrid ui-widget ui-widget-content ui-corner-all'> </ div>");
		. $ (Por exemplo) attr ({"id": "gbox_" + this.id, "dir": dir}). InsertBefore (gv);
		. $ (Gv) attr ("id", "gview_" + this.id) appendTo (por exemplo).;
		$ ("<div Class='ui-widget-overlay jqgrid-overlay' id='lui_"+this.id+"'> </ div>") insertBefore (gv).;
		$ ("<div Class='loading ui-state-default ui-state-active' id='load_"+this.id+"'>" + this.p.loadtext + "</ div>"). InsertBefore (gv );
		$(this).attr({cellspacing:"0",cellpadding:"0",border:"0","role":"grid","aria-multiselectable":!!this.p.multiselect,"aria-labelledby":"gbox_"+this.id});
		SORTKEYS var = ["shiftKey", "altKey", "ctrlKey"],
		intNum = function (val, defval) {
			val = parselnt (val, 10);
			if (isNaN (val)) {return defval | | 0;}
			retornar val;
		},
		formatCol = function (pos, rowInd, tv, rawObject, ROWID, rdata) {
			var cm = ts.p.colModel [pos],
			ral = cm.align, resultado = "style = \" ", clas = cm.classes, nm = cm.name, CELP, acp = [];
			if (ral) {resultado + = "text-align:" + ral + ",";}
			if (cm.hidden === true) {resultado + = "display: none;";}
			if (rowInd === 0) {
				. resultado + = "width:" largura + + grid.headers [pos] "px";;
			} Else if ($ cm.cellattr &&. IsFunction (cm.cellattr))
			{
				CELP = cm.cellattr.call (ts, ROWID, tv, rawObject, cm, rdata);
				if (CELP && typeof CELP === "string") {
					. CELP = celp.replace (/ estilo / i, "estilo") replace (/ title / i, 'title');
					if (celp.indexOf ('title')> -1) {cm.title = false;}
					if (celp.indexOf ('class')> -1) {clas = indefinido;}
					. acp = celp.replace ('estilo', '-sti') split (/ estilo /);
					if (acp.length === 2) {
						. acp [1] = $ trim (acp [1] replace ('-sti', 'estilo') substituir ("=", "")..);
						if (acp [1] indexOf ("'") === 0 | |. acp [1] indexOf ('. '") === 0) {
							acp [1] = acp [1] substring (1).;
						}
						. resultado + = acp [1] replace (/ '/ gi,' "');
					} Else {
						resultado + = "\" ";
					}
				}
			}
			if (acp.length!) {acp [0] = ""; resultado + = "\" ";}
			resultado + = (clas == indefinido ("class = \" "+ clas +" \ ""):? "")? + ((cm.title && tv) (". title = \" "+ $ jgrid. stripHtml (tv) + "\" "):" ");
			resultado + = "aria-describedby = \" "+ ts.p.id +" _ "+ nm +" \ "";
			resultado de retorno + acp [0];
		},
		cellVal = function (val) {
			voltar val == null | | val === ""? "": (Ts.p.autoencode $ jgrid.htmlEncode (val):. String (val));
		},
		formatador = function (ROWID, cellval, colpos, rwdat, _act) {
			var cm = ts.p.colModel [colpos], v;
			if (cm.formatter! == indefinido) {
				rowid = String (ts.p.idPrefix)! == ""? . $ Jgrid.stripPref (ts.p.idPrefix, ROWID): ROWID;
				var opts = {RowId: ROWID, colModel: cm, gid: ts.p.id, pos: colpos};
				if ($. isFunction (cm.formatter)) {
					v = cm.formatter.call (ts, cellval, opta, rwdat, _act);
				} Else if ($. Fmatter) {
					. v = $ fn.fmatter.call (ts, cm.formatter, cellval, opta, rwdat, _act);
				} Else {
					v = cellVal (cellval);
				}
			} Else {
				v = cellVal (cellval);
			}
			retornar v;
		},
		addCell = function (ROWID, celular, pos, irow, srvr, rdata) {
			var v, prp;
			v = formatador (ROWID, celular, pos, srvr, 'add');
			prp = formatCol (pos, irow, v, srvr, ROWID, rdata);
			voltar "<td role=\"gridcell\" "+prp+">" + v + "</ td>";
		},
		addMulti = function (rowid, pos, irow, marcada) {
			var v = "<papel de entrada = \" opção \ "type = \" caixa \ "" + "id = \" jqg_ "+ ts.p.id +" _ "+ rowid +" \ "class = \" cbox \ " name = \ "jqg_" + ts.p.id + "_" + rowid + "\" "+ (? verificado" checked = \ "checked \" ":" ") +" /> ",
			prp = formatCol (pos, irow,'', null, rowid, true);
			voltar "<td role=\"gridcell\" "+prp+">" + v + "</ td>";
		},
		addRowNum = function (pos, irow, PG, RN) {
			var v = (parseInt (PG, 10) -1) * parseInt (RN, 10) +1 + irow,
			prp = formatCol (pos, irow, v, null, irow, true);
			voltar "<td role=\"gridcell\" class=\"ui-state-default jqgrid-rownum\" "+prp+">" + v + "</ td>";
		},
		leitor = function (tipo de dados) {
			campo var, f = [], j = 0, i;
			for (i = 0; i <ts.p.colModel.length; i + +) {
				field = ts.p.colModel [i];
				if (field.name! == 'cb' && field.name! == 'subgrid' && field.name! == 'rn') {
					f [j] = tipo de dados === "local"?
					field.name:
					((Tipo de dados === "xml" | | tipo de dados === "xmlString") field.xmlmap | | field.name: field.jsonmap | | field.name);
					if (ts.p.keyIndex == field.key! falso && === true) {
						ts.p.keyName = f [j];
					}
					j + +;
				}
			}
			retornar f;
		},
		orderedCols = function (offset) {
			ordem var = ts.p.remapColumns;
			if (ordem | |! order.length) {
				order = $ map (ts.p.colModel, function (v, i) {return i;}).;
			}
			if (offset) {
				. order = $ map (ordem, function (v) {? retorno v <compensar nulo: v-offset;});
			}
			voltar ordem;
		},
		emptyRows = function (rolagem, locdata) {
			var firstrow;
			if (this.p.deepempty) {
				.. $ (This.rows) fatia (1) remove ();
			} Else {
				firstrow = this.rows.length> 0? this.rows [0]: nulos;
				.. $ (This.firstChild) empty () anexa (firstrow);
			}
			if (role && this.p.scroll) {
				. $ (This.grid.bDiv.firstChild) css ({height: "auto"});
				. $ (This.grid.bDiv.firstChild.firstChild) css ({height: 0, display: "none"});
				if (this.grid.bDiv.scrollTop! == 0) {
					this.grid.bDiv.scrollTop = 0;
				}
			}
			if (locdata === verdadeiro && this.p.treeGrid) {
				this.p.data = []; this.p._index = {};
			}
		},
		refreshIndex = function () {
			var DataLen = ts.p.data.length, idname, i, val,
			ni = ts.p.rownumbers === verdadeiros? 1: 0,
			gi = ts.p.multiselect === verdade? 1: 0,
			si = ts.p.subGrid === verdade? 1: 0;

			if (ts.p.keyIndex === false | | ts.p.loadonce === true) {
				idname = ts.p.localReader.id;
			} Else {
				. idname = ts.p.colModel [ts.p.keyIndex + gi + si + ni] nome;
			}
			for (i = 0; i <DataLen; i + +) {
				. val = $ jgrid.getAccessor (ts.p.data [i], idname);
				if (val === indefinido) {val = String (i +1);}
				ts.p._index [val] = i;
			}
		},
		constructTr = function (id, esconder, altClass, rd, cur, selecionado) {
			var tabindex = "-1", restAttr ='', AttrName, style = esconder? 'Display: none;':'',
				aulas = 'jqgrow ui-widget-content ui-row-' + ts.p.direction + (altClass '?' + altClass:'') + (selecionado? 'ui-state-destaque':''),
				rowAttrObj = $ (ts) triggerHandler ("jqGridRowAttr" [rd, cur, id]).;
				if (typeof rowAttrObj! == "objeto") {
					rowAttrObj = $. isFunction (ts.p.rowattr)? ts.p.rowattr.call (ts, rd, cur, id): {};
				}
			if (! $. isEmptyObject (rowAttrObj)) {
				if (rowAttrObj.hasOwnProperty ("id")) {
					ID = rowAttrObj.id;
					excluir rowAttrObj.id;
				}
				if (rowAttrObj.hasOwnProperty ("tabindex")) {
					tabindex = rowAttrObj.tabindex;
					excluir rowAttrObj.tabindex;
				}
				if (rowAttrObj.hasOwnProperty ("estilo")) {
					estilo + = rowAttrObj.style;
					excluir rowAttrObj.style;
				}
				if (rowAttrObj.hasOwnProperty ("class")) {
					aulas + = '' + rowAttrObj ['classe'];
					excluir rowAttrObj ['classe'];
				}
				/ / Dot't permitir alterar o atributo papel
				try {apagar rowAttrObj.role;} catch (ra) {}
				para (AttrName em rowAttrObj) {
					if (rowAttrObj.hasOwnProperty (AttrName)) {
						restAttr + = '' + AttrName + '=' + rowAttrObj [AttrName];
					}
				}
			}
			retorno '<tr role = "linha" id = "" + id +' "tabindex =" '+ tabindex +' "class =" '+ classes +' "'+
				+ RestAttr + '>';: (estilo ==='''' 'style = "' + estilo + '"'?)
		},
		addXmlData = function (xml, t, RCNT, mais, ajustar) {
			var startReq = new Date (),
			locdata = (ts.p.datatype == "local" && ts.p.loadonce!) | | ts.p.datatype === "xmlString",
			xmlid = "_ID_", xmlRd = ts.p.xmlReader,
			FRD = ts.p.datatype === "local"? "Local": "xml";
			if (locdata) {
				ts.p.data = [];
				ts.p._index = {};
				ts.p.localReader.id = xmlid;
			}
			ts.p.reccount = 0;
			if ($. isXMLDoc (xml)) {
				if (ts.p.scroll ts.p.treeANode === -1 &&!) {
					emptyRows.call (ts, falso, true);
					RCNT = 1;
				} Else {RCNT = RCNT> 1? RCNT: 1;}
			} Else {return;}
			var self = $ (ts), i, fPos, ri = 0, v, gi = ts.p.multiselect === verdade? 1:0, si = 0, addSubGridCell, = ni ts.p.rownumbers === verdade? 1:0, IDN, getId, f = [], F, rd = {}, Xmlr, livre, RowData = [], cn = (ts.p.altRows === verdadeiros)? ts.p.altclass: "", CN1;
			if (ts.p.subGrid === true) {
				SI = 1;
				. addSubGridCell = $ jgrid.getMethod ("addSubGridCell");
			}
			Se {f = leitor (FRD);} (xmlRd.repeatitems!)
			if (ts.p.keyIndex === false) {
				idn = $. isFunction (xmlRd.id)? xmlRd.id.call (ts, xml): xmlRd.id;
			} Else {
				idn = ts.p.keyIndex;
			}
			if (f.length> 0 &&! isNaN (IDN)) {
				idn = ts.p.keyName;
			}
			if (String (IDN). indexOf ("[") === -1) {
				if (f.length) {
					getId = function (Trow, k) {. retornar $ (IDN, Trow) text () | | k;};
				} Else {
					getId = function (Trow, k) {.. retornar $ (xmlRd.cell, Trow) eq (IDN) text () | | k;};
				}
			}
			else {
				getId = function (Trow, k) {return trow.getAttribute (idn.replace (/ [\ [\]] / g, "")) | | k;};
			}
			ts.p.userData = {};
			ts.p.page = intNum ($ jgrid.getXmlData (xml, xmlRd.page), ts.p.page.);
			(. $ jgrid.getXmlData (xml, xmlRd.total), 1) = ts.p.lastpage intNum;
			ts.p.records = intNum ($ jgrid.getXmlData (xml, xmlRd.records).);
			if ($. isFunction (xmlRd.userdata)) {
				ts.p.userData = xmlRd.userdata.call (ts, xml) | | {};
			} Else {
				.. $ Jgrid.getXmlData (xml, xmlRd.userdata, true) each (function () {. Ts.p.userData [this.getAttribute ("nome")] = $ (this) text ();});
			}
			. var GXml = $ jgrid.getXmlData (xml, xmlRd.root, true);
			. GXml = $ jgrid.getXmlData (GXml, xmlRd.row, true);
			if (GXml!) {GXml = [];}
			?. var gl = gxml.length, j = 0, grpdata = [], rn = parselnt (ts.p.rowNum, 10), br = ts.p.scroll jgrid.randId $ (): 1, altr;
			if (gl> 0 && ts.p.page <= 0) {ts.p.page = 1;}
			if (GXml && gl) {
			if (ajustar) {rn * = ajustar +1;}
			var afterInsRow = $ isFunction (ts.p.afterInsertRow), hiderow = false, groupingPrepare.;
			if (ts.p.grouping) {
				hiderow = ts.p.groupingView.groupCollapse === true;
				. groupingPrepare = $ jgrid.getMethod ("groupingPrepare");
			}
			while (j <gl) {
				Xmlr = GXml [j];
				rid = getId (Xmlr, br + j);
				rid = ts.p.idPrefix + livrar;
				altr = RCNT === 0? 0: RCNT +1;
				CN1 = (altr + j) 1% 2 ===? cn:'';
				var iStartTrTag = rowData.length;
				rowData.push ("");
				if (ni) {
					rowData.push (addRowNum (0, j, ts.p.page, ts.p.rowNum));
				}
				if (gi) {
					rowData.push (addMulti (livrar, ni, j, false));
				}
				se (si) {
					rowData.push (addSubGridCell.call (self, gi + ni, j + RCNT));
				}
				if () {xmlRd.repeatitems
					Se {F = orderedCols (gi + si + ni);} (F!)
					. células var = $ jgrid.getXmlData (Xmlr, xmlRd.cell, true);
					$. Cada (F, function (k) {
						célula var = células [este];
						Se {return false;} (celular!)
						v = cell.textContent | | cell.text;
						º [. ts.p.colModel [k + gi + si + ni] name] = v;
						rowData.push (addCell (livrar, v, k + gi + si + ni, j + RCNT, Xmlr, rd));
					});
				} Else {
					for (i = 0; i <f.length; i + +) {
						. v = $ jgrid.getXmlData (Xmlr, f [i]);
						rd [ts.p.colModel [i + gi + si + ni] nome.] = v;
						rowData.push (addCell (livrar, v, i + gi + si + ni, j + RCNT, Xmlr, rd));
					}
				}
				RowData [iStartTrTag] = constructTr (livrar, hiderow, CN1, rd, Xmlr, false);
				rowData.push ("</ tr>");
				if (ts.p.grouping) {
					grpdata = groupingPrepare.call (self, RowData, grpdata, rd, j);
					RowData = [];
				}
				if (locdata | | ts.p.treeGrid === true) {
					. rd [xmlid] = $ jgrid.stripPref (ts.p.idPrefix, livrar);
					ts.p.data.push (rd);
					ts.p._index [estr [xmlid]] = ts.p.data.length-1;
				}
				if (ts.p.gridview === false) {
					$ ("Tbody: em primeiro lugar", t) append (rowData.join (''));.
					self.triggerHandler ("jqGridAfterInsertRow", [rid, rd, Xmlr]);
					if (afterInsRow) {ts.p.afterInsertRow.call (ts, livrar, rd, Xmlr);}
					RowData = [];
				}
				rd = {};
				ri + +;
				j + +;
				if (ri === rn) {break;}
			}
			}
			if (ts.p.gridview === true) {
				fPos = ts.p.treeANode> -1? ts.p.treeANode: 0;
				if (ts.p.grouping) {
					self.jqGrid ('groupingRender', grpdata, ts.p.colModel.length);
					grpdata = null;
				} Else if (ts.p.treeGrid === verdadeiros && fPos> 0) {
					$ (Ts.rows [fPos]) depois (rowData.join ('')).;
				} Else {
					$ ("Tbody: em primeiro lugar", t) append (rowData.join (''));.
				}
			}
			if (ts.p.subGrid === true) {
				try {self.jqGrid ("addSubGrid", gi + ni);} catch (_) {}
			}
			ts.p.totaltime = new Date () - startReq;
			if (ri> 0) {if (ts.p.records === 0) {ts.p.records = gl;}}
			RowData = null;
			if (ts.p.treeGrid === true) {
				try {self.jqGrid ("setTreeNode", fPos +1, ir + fPos +1);} catch (e) {}
			}
			(! ts.p.treeGrid && ts.p.scroll) se {ts.grid.bDiv.scrollTop = 0;}
			ts.p.reccount = IR;
			ts.p.treeANode = -1;
			if (ts.p.userDataOnFooter) {self.jqGrid ("footerData", "set", ts.p.userData, true);}
			if (locdata) {
				ts.p.records = gl;
				ts.p.lastpage = Math.ceil (gl / RN);
			}
			Se {ts.updatepager (false, true);} (muito mais!)
			if (locdata) {
				while (ri <gl) {
					Xmlr = GXml [ri];
					rid = getId (Xmlr, ir + br);
					rid = ts.p.idPrefix + livrar;
					if () {xmlRd.repeatitems
						Se {F = orderedCols (gi + si + ni);} (F!)
						. var cells2 = $ jgrid.getXmlData (Xmlr, xmlRd.cell, true);
						$. Cada (F, function (k) {
							célula var = cells2 [este];
							Se {return false;} (celular!)
							v = cell.textContent | | cell.text;
							º [. ts.p.colModel [k + gi + si + ni] name] = v;
						});
					} Else {
						for (i = 0; i <f.length; i + +) {
							. v = $ jgrid.getXmlData (Xmlr, f [i]);
							rd [ts.p.colModel [i + gi + si + ni] nome.] = v;
						}
					}
					. rd [xmlid] = $ jgrid.stripPref (ts.p.idPrefix, livrar);
					ts.p.data.push (rd);
					ts.p._index [estr [xmlid]] = ts.p.data.length-1;
					rd = {};
					ri + +;
				}
			}
		},
		addJSONData = function (dados, t, RCNT, mais, ajustar) {
			var startReq = new Date ();
			se (dados) {
				if (ts.p.scroll ts.p.treeANode === -1 &&!) {
					emptyRows.call (ts, falso, true);
					RCNT = 1;
				} Else {RCNT = RCNT> 1? RCNT: 1;}
			} Else {return;}

			var Dreader, locid = "_ID_", FRD,
			locdata = (ts.p.datatype == "local" && ts.p.loadonce!) | | ts.p.datatype === "jsonstring";
			if (locdata) {ts.p.data = []; ts.p._index = {}; ts.p.localReader.id = locid;}
			ts.p.reccount = 0;
			if (ts.p.datatype === "local") {
				Dreader = ts.p.localReader;
				FRD = 'local';
			} Else {
				Dreader = ts.p.jsonReader;
				FRD = 'json';
			}
			var self = $ (ts), fPos, IDR, RowData = [], cn = (ts.p.altRows === true)? ts.p.altclass: "", CN1;
			ts.p.page = intNum ($ jgrid.getAccessor (dados, dReader.page), ts.p.page.);
			(. $ jgrid.getAccessor (dados, dReader.total), 1) = ts.p.lastpage intNum;
			ts.p.records = intNum ($ jgrid.getAccessor (dados, dReader.records).);
			. ts.p.userData = $ jgrid.getAccessor (dados, dReader.userdata) | | {};
			se (si) {
				. addSubGridCell = $ jgrid.getMethod ("addSubGridCell");
			}
			if (ts.p.keyIndex === false) {
				idn = $. isFunction (dReader.id)? dReader.id.call (ts, dados): dReader.id;
			} Else {
				idn = ts.p.keyIndex;
			}
			if (! dReader.repeatitems) {
				f = objectReader;
				if (f.length> 0 &&! isNaN (IDN)) {
					idn = ts.p.keyName;
				}
			}
			. drows = $ jgrid.getAccessor (dados, dReader.root);
			se {drows = dados;} (drows == null && $ isArray (dados).)
			if (!) {drows drows = [];}
			len = drows.length; i = 0;
			if (len> 0 && ts.p.page <= 0) {ts.p.page = 1;}
			?. var rn = parseInt (ts.p.rowNum, 10), br = ts.p.scroll $ jgrid.randId (): 1, altr, selecionado = false, selr;
			if (ajustar) {rn * = ajustar +1;}
			if (ts.p.datatype === "local" &&! ts.p.deselectAfterSort) {
				selecionado = true;
			}
			var afterInsRow = $ isFunction (ts.p.afterInsertRow), grpdata = [], hiderow = false, groupingPrepare.;
			if (ts.p.grouping) {
				hiderow = ts.p.groupingView.groupCollapse === true;
				. groupingPrepare = $ jgrid.getMethod ("groupingPrepare");
			}
			while (i <len) {
				cur = drows [i];
				. idr = $ jgrid.getAccessor (cur, IDN);
				if (IDR === indefinido) {
					if (typeof idn === "número" && ts.p.colModel [idn + gi + si + ni]! = null) {
						/ / Id reler por nome
						. idr = $ jgrid.getAccessor (cur, ts.p.colModel [idn + gi + si + ni] nome.);
					}
					if (IDR === indefinido) {
						IDR = br + i;
						if (f.length === 0) {
							if (dReader.cell) {
								. var CCur = $ jgrid.getAccessor (cur, dReader.cell) | | cur;
								IDR = CCur! = null && CCur [idn]! == indefinido? CCur [idn]: IDR;
								CCur = null;
							}
						}
					}
				}
				IDR = ts.p.idPrefix + IDR;
				altr = RCNT === 1? 0: RCNT;
				CN1 = (altr + i)% 2 === 1? cn:'';
				if (seleccionado) {
					if (ts.p.multiselect) {
						selr = (.! $ inArray (IDR, ts.p.selarrrow) == -1);
					} Else {
						selr = (IDR === ts.p.selrow);
					}
				}
				var iStartTrTag = rowData.length;
				rowData.push ("");
				if (ni) {
					rowData.push (addRowNum (0, i, ts.p.page, ts.p.rowNum));
				}
				if (gi) {
					rowData.push (addMulti (IDR, ni, i, selr));
				}
				se (si) {
					rowData.push (addSubGridCell.call (self, gi + ni, i + RCNT));
				}
				rowReader = objectReader;
				if () {dReader.repeatitems
					if (dReader.cell) {cur = $ jgrid.getAccessor (cur, dReader.cell) | | cur;.}
					if ($ isArray (cur).) {rowReader = arrayReader;}
				}
				for (j = 0; j <rowReader.length; j + +) {
					. v = $ jgrid.getAccessor (cur, rowReader [j]);
					º [. ts.p.colModel [j + gi + si + ni] name] = v;
					rowData.push (addCell (IDR, v, j + gi + si + ni, i + RCNT, cur, rd));
				}
				RowData [iStartTrTag] = constructTr (IDR, hiderow, CN1, rd, cur, selr);
				rowData.push ("</ tr>");
				if (ts.p.grouping) {
					grpdata = groupingPrepare.call (self, RowData, grpdata, rd, i);
					RowData = [];
				}
				if (locdata | | ts.p.treeGrid === true) {
					. rd [locid] = $ jgrid.stripPref (ts.p.idPrefix, idr);
					ts.p.data.push (rd);
					ts.p._index [rd [locid]] = ts.p.data.length-1;
				}
				if (ts.p.gridview === false) {
					. $ (. "#" + $ Jgrid.jqID (ts.p.id) + "tbody: primeiro") append (rowData.join (''));
					self.triggerHandler ("jqGridAfterInsertRow" [IDR, rd, cur]);
					if (afterInsRow) {ts.p.afterInsertRow.call (ts, IDR, rd, cur);}
					RowData = [] ;/ / ari = 0;
				}
				rd = {};
				ri + +;
				i + +;
				if (ri === rn) {break;}
			}
			if (ts.p.gridview === true) {
				fPos = ts.p.treeANode> -1? ts.p.treeANode: 0;
				if (ts.p.grouping) {
					self.jqGrid ('groupingRender', grpdata, ts.p.colModel.length);
					grpdata = null;
				} Else if (ts.p.treeGrid === verdadeiros && fPos> 0) {
					$ (Ts.rows [fPos]) depois (rowData.join ('')).;
				} Else {
					. $ (. "#" + $ Jgrid.jqID (ts.p.id) + "tbody: primeiro") append (rowData.join (''));
				}
			}
			if (ts.p.subGrid === true) {
				try {self.jqGrid ("addSubGrid", gi + ni);} catch (_) {}
			}
			ts.p.totaltime = new Date () - startReq;
			if (ri> 0) {
				if (ts.p.records === 0) {ts.p.records = len;}
			}
			RowData = null;
			if (ts.p.treeGrid === true) {
				try {self.jqGrid ("setTreeNode", fPos +1, ir + fPos +1);} catch (e) {}
			}
			(! ts.p.treeGrid && ts.p.scroll) se {ts.grid.bDiv.scrollTop = 0;}
			ts.p.reccount = IR;
			ts.p.treeANode = -1;
			if (ts.p.userDataOnFooter) {self.jqGrid ("footerData", "set", ts.p.userData, true);}
			if (locdata) {
				ts.p.records = len;
				ts.p.lastpage = Math.ceil (len / RN);
			}
			Se {ts.updatepager (false, true);} (muito mais!)
			if (locdata) {
				while (ri <len && drows [ri]) {
					cur = drows [ri];
					. idr = $ jgrid.getAccessor (cur, IDN);
					if (IDR === indefinido) {
						if (typeof idn === "número" && ts.p.colModel [idn + gi + si + ni]! = null) {
							/ / Id reler por nome
							. idr = $ jgrid.getAccessor (cur, ts.p.colModel [idn + gi + si + ni] nome.);
						}
						if (IDR === indefinido) {
							IDR = br + ri;
							if (f.length === 0) {
								if (dReader.cell) {
									. var ccur2 = $ jgrid.getAccessor (cur, dReader.cell) | | cur;
									IDR = ccur2! = null && ccur2 [idn]! == indefinido? ccur2 [idn]: IDR;
									ccur2 = null;
								}
							}
						}
					}
					if (cur) {
						IDR = ts.p.idPrefix + IDR;
						rowReader = objectReader;
						if () {dReader.repeatitems
							if (dReader.cell) {cur = $ jgrid.getAccessor (cur, dReader.cell) | | cur;.}
							if ($ isArray (cur).) {rowReader = arrayReader;}
						}

						for (j = 0; j <rowReader.length; j + +) {
							. rd [. ts.p.colModel [j + gi + si + ni] nome] = $ jgrid.getAccessor (cur, rowReader [j]);
						}
						. rd [locid] = $ jgrid.stripPref (ts.p.idPrefix, idr);
						ts.p.data.push (rd);
						ts.p._index [rd [locid]] = ts.p.data.length-1;
						rd = {};
					}
					ri + +;
				}
			}
		},
		addLocalData = function () {
			var st = ts.p.multiSort? []: "", Sto = [], fndsort = false, cmtypes = {}, grtypes = [], grindexes = [], srcformat, sorttype, newFormat;
			if (! $. isArray (ts.p.data)) {
				retorno;
			}
			var grpview = ts.p.grouping? ts.p.groupingView: false, lengrp, gin;
			$. Cada (ts.p.colModel, function () {
				sorttype = this.sorttype | | "texto";
				if (sorttype === "date" | | sorttype === "datetime") {
					if (typeof this.formatter && this.formatter === 'string' && this.formatter === 'date') {
						if (this.formatoptions && this.formatoptions.srcformat) {
							srcformat = this.formatoptions.srcformat;
						} Else {
							. srcformat = $ jgrid.formatter.date.srcformat;
						}
						if (this.formatoptions && this.formatoptions.newformat) {
							newFormat = this.formatoptions.newformat;
						} Else {
							. newFormat = $ jgrid.formatter.date.newformat;
						}
					} Else {
						srcformat = newFormat = this.datefmt | | "Ymd";
					}
					cmtypes [this.name] = {"stype": sorttype, "srcfmt": srcformat, "newfmt": newFormat};
				} Else {
					cmtypes [this.name] = {"stype": sorttype ", srcfmt":'', "newfmt":''};
				}
				if (ts.p.grouping) {
					for (gin = 0, lengrp = grpview.groupField.length; gin <lengrp; gin + +) {
						if (this.name === grpview.groupField [gin]) {
							var Grindex = this.name;
							if (this.index) {
								Grindex = this.index;
							}
							grtypes [gin] = cmtypes [Grindex];
							grindexes [gin] = Grindex;
						}
					}
				}
				if (ts.p.multiSort) {
					if (this.lso) {
						st.push (this.name);
						var tmplso this.lso.split = ("-");
						sto.push (tmplso [tmplso.length-1]);
					}
				} Else {
					if (fndsort && (this.index === ts.p.sortname |! | this.name === ts.p.sortname)) {
						st = this.name / /??
						fndsort = true;
					}
				}
			});
			if (ts.p.treeGrid) {
				. $ (Ts) jqGrid (". SortTree", do st ts.p.sortorder, cmtypes [ST] stype | | 'texto', cmtypes [st] srcfmt | |.'');
				retorno;
			}
			var compareFnMap = {
				'Eq': function () {queryObj queryObj.equals retorno;},
				'Ne': function () {queryObj queryObj.notEquals retorno;},
				"Lt": function (queryObj) {return queryObj.less;},
				'Le': function () {queryObj queryObj.lessOrEquals return;},
				'Gt': function (queryObj) {return queryObj.greater;},
				'Ge': function () {queryObj queryObj.greaterOrEquals retorno;},
				'Cn': function () {queryObj queryObj.contains retorno;},
				'Nc': function (queryObj, op) {return op === "ou"? .. queryObj.orNot () contém: queryObj.andNot () contém;},
				'Pc': function (queryObj) {return queryObj.startsWith;},
				'Bi': function (queryObj, op) {return op === "ou"? .. queryObj.orNot () startsWith: queryObj.andNot () startsWith;}
				'En': function (queryObj, op) {return op === "ou"? queryObj.orNot () endsWith:.. queryObj.andNot () endsWith;}
				'Ew': function (queryObj) {return queryObj.endsWith;},
				'Ni': function (queryObj, op) {return op === "ou"? . queryObj.orNot () é igual a: queryObj.andNot () é igual;},.
				'Em': function () {queryObj queryObj.equals retorno;},
				'nu': function () {return queryObj queryObj.isNull;},
				'Nn': function (queryObj, op) {return op === "ou"? .. queryObj.orNot () isNull: queryObj.andNot () isNull;}

			},
			. query = $ jgrid.from (ts.p.data);
			if (ts.p.ignoreCase) {query = query.ignoreCase ();}
			função tojLinq (grupo) {
				var s = 0, índice, gor, ror, opr, regra;
				if (group.groups! = null) {
					. gor = group.groups.length && group.groupOp.toString () toUpperCase () === "OU";
					if (gor) {
						query.orBegin ();
					}
					for (index = 0; índice <group.groups.length; índice + +) {
						if (s> 0 && gor) {
							query.or ();
						}
						try {
							tojLinq (group.groups [index]);
						} Catch (e) {alert (e);}
						s + +;
					}
					if (gor) {
						query.orEnd ();
					}
				}
				if (group.rules! = null) {
					/ / If (s> 0) {
					/ / Var resultado = query.select ();
					/ / Query = $ jgrid.from (resultado).;
					/ / If (ts.p.ignoreCase) {query = query.ignoreCase ();} 
					/ /}
					try {
						. ror = group.rules.length && group.groupOp.toString () toUpperCase () === "OU";
						if (ROR) {
							query.orBegin ();
						}
						for (index = 0; índice <group.rules.length; índice + +) {
							rule = group.rules [índice];
							opr = group.groupOp.toString () toUpperCase ().;
							if (compareFnMap [rule.op] && rule.field) {
								if (s> 0 && && opr opr ​​=== "OR") {
									query = query.or ();
								}
								query = compareFnMap [rule.op] (consulta, opr) (rule.field, rule.data, cmtypes [rule.field]);
							}
							s + +;
						}
						if (ROR) {
							query.orEnd ();
						}
					} Catch (g) {alert (g);}
				}
			}

			if (ts.p.search === true) {
				srules var = ts.p.postData.filters;
				if () {srules
					if (typeof srules === "string") {srules = $ jgrid.parse (srules);.}
					tojLinq (srules);
				} Else {
					try {
						query = compareFnMap [ts.p.postData.searchOper] (query) (ts.p.postData.searchField, ts.p.postData.searchString, cmtypes [ts.p.postData.searchField]);
					} Catch (se) {}
				}
			}
			if (ts.p.grouping) {
				for (gin = 0; gin <lengrp; gin + +) {
					query.orderBy (grindexes [gin], grpview.groupOrder [gin], grtypes [gin] stype, grtypes [gin] srcfmt..);
				}
			}
			if (ts.p.multiSort) {
				$. Cada (st, function (i) {
					query.orderBy (este, sto [i], cmtypes [este] stype, cmtypes [este] srcfmt..);
				});
			} Else {
				se (st && ts.p.sortorder && fndsort) {
					if (ts.p.sortorder.toUpperCase () === "DESC") {
						query.orderBy (.. ts.p.sortname, "d", cmtypes [st] stype, cmtypes [st] srcfmt);
					} Else {
						query.orderBy (.. ts.p.sortname, "a", cmtypes [st] stype, cmtypes [st] srcfmt);
					}
				}
			}
			QueryResults var = query.select (),
			recordsperpage = parseInt (ts.p.rowNum, 10),
			Total = queryResults.length,
			page = parseInt (ts.p.page, 10),
			TotalPages = Math.ceil (total / recordsperpage),
			retresult = {};
			QueryResults = queryResults.slice ((página-1) * recordsperpage, página * recordsperpage);
			query = null;
			cmtypes = null;
			retresult [ts.p.localReader.total] = TotalPages;
			retresult [ts.p.localReader.page] = página;
			retresult [ts.p.localReader.records] = total;
			retresult [ts.p.localReader.root] = QueryResults;
			retresult [ts.p.localReader.userdata] = ts.p.userData;
			QueryResults = null;
			voltar retresult;
		},
		updatepager = function (rn, dnd) {
			var cp, última, base, de, para, pequeno, fmt, pgboxes = "", sppg,
			tspg = ts.p.pager? "_" + $ Jgrid.jqID (ts.p.pager.substr (1)): ".",
			tspg_t = ts.p.toppager? "_" + Ts.p.toppager.substr (1): "";
			base = parseInt (ts.p.page, 10) -1;
			se (base <0) {base = 0;}
			base = base * parseInt (ts.p.rowNum, 10);
			a = base + ts.p.reccount;
			if (ts.p.scroll) {
				linhas var = $ ("tbody: em primeiro lugar> tr: gt (0)", ts.grid.bDiv);
				base = a - rows.length;
				ts.p.reccount = rows.length;
				var rh = rows.outerHeight () | | ts.grid.prevRowHeight;
				if (rh) {
					var top = base * rh;
					var altura = parseInt (ts.p.records, 10) * rh;
					$. ("> Div: em primeiro lugar", ts.grid.bDiv) css ({height: altura}). Crianças. ("Div: primeiro") css ({height: top, exibição: top "?": "Nenhum "});
					if (ts.grid.bDiv.scrollTop == 0 && ts.p.page> 1) {
						ts.grid.bDiv.scrollTop = ts.p.rowNum * (ts.p.page - 1) * rh;
					}
				}
				ts.grid.bDiv.scrollLeft = ts.grid.hDiv.scrollLeft;
			}
			pgboxes = ts.p.pager | | "";
			pgboxes + = ts.p.toppager? (? pgboxes "," + ts.p.toppager: ts.p.toppager): "";
			if () {pgboxes
				. fmt = $ jgrid.formatter.integer | | {};
				cp = intNum (ts.p.page);
				last = intNum (ts.p.lastpage);
				$ (". Selbox", pgboxes) [this.p.useProp? 'Sustentar': 'attr'] ("desativado", false);
				if (ts.p.pginput === true) {
					. $ ('. Ui-pg-entrada', pgboxes) val (ts.p.page);
					sppg = ts.p.toppager? '# Sp_1' + tspg + ", # sp_1" + tspg_t: '# sp_1' + tspg;
					. (.?. $ Fmatter $ fmatter.util.NumberFormat (ts.p.lastpage, fmt): ts.p.lastpage) $ (sppg) html;

				}
				if () {ts.p.viewrecords
					if (ts.p.reccount === 0) {
						. $ (". Ui-paginação-info", pgboxes) html (ts.p.emptyrecords);
					} Else {
						a partir de 1 = base;
						tot = ts.p.records;
						if ($. fmatter) {
							from = $ fmatter.util.NumberFormat (de, fmt).;
							a = $ fmatter.util.NumberFormat (a, fmt).;
							. tot = $ fmatter.util.NumberFormat (tot, fmt);
						}
						. $ (". Ui-paginação-info", pgboxes) html (. $ Jgrid.format (ts.p.recordtext, de, para, pequeno));
					}
				}
				if (ts.p.pgbuttons === true) {
					if (cp <= 0) {cp = last = 0;}
					if (cp === 1 | | cp === 0) {
						$ ("# Primeiro" + tspg + ", # prev" + tspg) addClass ('ui-state-deficientes ") removeClass (' ui-state-pairar ')..;
						if (ts.p.toppager) {$ ("# first_t" + tspg_t + ", # prev_t" + tspg_t) addClass ('ui-state-deficientes ") removeClass (' ui-state-pairar ');..}
					} Else {
						$ ("# Primeiro" + tspg + ", # prev" + tspg) removeClass ('ui-state-deficientes ").;
						if (ts.p.toppager) {$ ("# first_t" + tspg_t + ", # prev_t" + tspg_t) removeClass ('ui-state-deficientes ");.}
					}
					if (cp === última | | cp === 0) {
						. $ ("# Próximo" + tspg + ", # última" + tspg) addClass ('ui-estado desativado') removeClass ('ui-state-pairar').;
						if (ts.p.toppager) {$ ("# next_t" + tspg_t + ", # last_t" + tspg_t) addClass ('ui-state-deficientes ") removeClass (' ui-state-pairar ');..}
					} Else {
						$ ("# Próximo" + tspg + ", # última" + tspg) removeClass ('ui-state-deficientes ").;
						if (ts.p.toppager) {$ ("# next_t" + tspg_t + ", # last_t" + tspg_t) removeClass ('ui-state-deficientes ");.}
					}
				}
			}
			if (rn === verdadeiros && ts.p.rownumbers === true) {
				$ ("> Td.jqgrid-rownum", ts.rows). Cada (function (i) {
					. $ (This) html (base 1 + i);
				});
			}
			if (dnd && ts.p.jqgdnd) {$ (ts) jqGrid ('gridDnD', 'updateDnD');.}
			. $ (Ts) triggerHandler ("jqGridGridComplete");
			Se {ts.p.gridComplete.call (ts);} ($ isFunction (ts.p.gridComplete).)
			. $ (Ts) triggerHandler ("jqGridAfterGridComplete");
		},
		beginReq = function () {
			ts.grid.hDiv.loading = true;
			if (ts.p.hiddengrid) {return;}
			switch (ts.p.loadui) {
				caso "desativar":
					break;
				caso "liberação":
					. $ (". # Load_" + $ jgrid.jqID (ts.p.id)) show ();
					break;
				case "bloco":
					. $ (". # Lui_" + $ jgrid.jqID (ts.p.id)) show ();
					. $ (". # Load_" + $ jgrid.jqID (ts.p.id)) show ();
					break;
			}
		},
		endReq = function () {
			ts.grid.hDiv.loading = false;
			switch (ts.p.loadui) {
				caso "desativar":
					break;
				caso "liberação":
					(". # Load_" + $ jgrid.jqID (ts.p.id)) $ hide ().;
					break;
				case "bloco":
					(". # Lui_" + $ jgrid.jqID (ts.p.id)) $ hide ().;
					(". # Load_" + $ jgrid.jqID (ts.p.id)) $ hide ().;
					break;
			}
		},
		preencher = function (npágina) {
			if (ts.grid.hDiv.loading!) {
				var PVIS = ts.p.scroll && npágina === false,
				prm = {}, dt, dstr, PN = ts.p.prmNames;
				if (ts.p.page <= 0) {ts.p.page = Math.min (1, ts.p.lastpage);}
				if (pN.search == null!) {prm [pN.search] = ts.p.search;} if (pN.nd == null!) {prm [pN.nd] = new Date () getTime (. );}
				if (pN.rows == null!) {prm [pN.rows] = ts.p.rowNum;} if (pN.page == null!) {prm [pN.page] = ts.p.page;}
				if (pN.sort == null!) {prm [pN.sort] = ts.p.sortname;} if (pN.order == null!) {prm [pN.order] = ts.p.sortorder;}
				if (ts.p.rowTotal == null && pN.totalrows == null!) {prm [pN.totalrows] = ts.p.rowTotal;}
				var LCF = $. isFunction (ts.p.loadComplete), lc = LCF? ts.p.loadComplete: null;
				var ajustar = 0;
				npágina = npágina | | 1;
				if (npágina> 1) {
					if (pN.npage! == null) {
						prm [pN.npage] = npágina;
						ajustar = npágina - 1;
						npágina = 1;
					} Else {
						lc = function (req) {
							ts.p.page + +;
							ts.grid.hDiv.loading = false;
							if (LCF) {
								ts.p.loadComplete.call (ts, req);
							}
							preencher (npágina-1);
						};
					}
				} Else if (pN.npage! == Null) {
					excluir ts.p.postData [pN.npage];
				}
				if (ts.p.grouping) {
					$ (Ts) jqGrid ('groupingSetup').;
					var grp = ts.p.groupingView, gi, gs = "";
					for (gi = 0; gi <grp.groupField.length; gi + +) {
						var index = grp.groupField [gi];
						$. Cada (ts.p.colModel, function (cmIndex, cmValue) {
							if (cmValue.name === índice && cmValue.index) {
								index = cmValue.index;
							}
						});
						gs + = índice + "" + grp.groupOrder [gi] + ",";
					}
					prm [pN.sort] = gs + prm [pN.sort];
				}
				. $ Estender (ts.p.postData, PRM);
				var RCNT =! ts.p.scroll? 1: ts.rows.length-1;
				. var bfr = $ (ts) triggerHandler ("jqGridBeforeRequest");
				if (bfr === false | | bfr === 'stop') {return;}
				Se {ts.p.datatype.call (ts, ts.p.postData ", load_" + ts.p.id, RCNT, npágina, ajuste); return;} ($ isFunction (ts.p.datatype).)
				if ($. isFunction (ts.p.beforeRequest)) {
					bfr = ts.p.beforeRequest.call (ts);
					if (bfr === indefinido) {bfr = true;}
					if (bfr === false) {return;}
				}
				dt = ts.p.datatype.toLowerCase ();
				switch (dt)
				{
				case "json":
				case "jsonp":
				caso "xml":
				case "roteiro":
					$. Ajax ($. Estender ({
						url: ts.p.url,
						digite: ts.p.mtype,
						Tipo de dado: dt,
						Dados:. $ isFunction (ts.p.serializeGridData)? ts.p.serializeGridData.call (ts, ts.p.postData): ts.p.postData,
						sucesso: function (dados, do st xhr) {
							if ($. isFunction (ts.p.beforeProcessing)) {
								if (ts.p.beforeProcessing.call (ts, dados, do st xhr) === false) {
									endReq ();
									retorno;
								}
							}
							if (dt === "xml") {addXmlData (dados, ts.grid.bDiv, RCNT, npágina> 1, ajuste);}
							else {addJSONData (dados, ts.grid.bDiv, RCNT, npágina> 1, ajuste);}
							. $ (Ts) triggerHandler ("jqGridLoadComplete" [dados]);
							if (lc) {lc.call (ts, data);}
							. $ (Ts) triggerHandler ("jqGridAfterLoadComplete" [dados]);
							if (PVIS) {ts.grid.populateVisible ();}
							if (ts.p.loadonce | | ts.p.treeGrid) {ts.p.datatype = "local";}
							data = null;
							if (npágina === 1) {endReq ();}
						},
						erro: function (xhr, rua, err) {
							Se {ts.p.loadError.call (ts, xhr, rua, err);} ($ isFunction (ts.p.loadError).)
							if (npágina === 1) {endReq ();}
							xhr = null;
						},
						beforeSend: function (XHR, configurações) {
							var gotoreq = true;
							if ($. isFunction (ts.p.loadBeforeSend)) {
								gotoreq = ts.p.loadBeforeSend.call (ts, xhr, configurações); 
							}
							if (gotoreq === indefinido) {gotoreq = true;}
							if (gotoreq === false) {
								return false;
							}
								beginReq ();
							}
					}, $ Jgrid.ajaxOptions, ts.p.ajaxGridOptions)).;
				break;
				case "xmlString":
					beginReq ();
					dstr = typeof ts.p.datastr! == 'string'? . ts.p.datastr: $ parseXML (ts.p.datastr);
					addXmlData (dstr, ts.grid.bDiv);
					$ (Ts) triggerHandler ("jqGridLoadComplete" [dstr]).;
					if (LCF) {ts.p.loadComplete.call (ts, dstr);}
					$ (Ts) triggerHandler ("jqGridAfterLoadComplete" [dstr]).;
					ts.p.datatype = "local";
					ts.p.datastr = null;
					endReq ();
				break;
				case "jsonstring":
					beginReq ();
					if (typeof ts.p.datastr === 'string') {dstr = $ jgrid.parse (ts.p.datastr);.}
					else {dstr = ts.p.datastr;}
					addJSONData (dstr, ts.grid.bDiv);
					$ (Ts) triggerHandler ("jqGridLoadComplete" [dstr]).;
					if (LCF) {ts.p.loadComplete.call (ts, dstr);}
					$ (Ts) triggerHandler ("jqGridAfterLoadComplete" [dstr]).;
					ts.p.datatype = "local";
					ts.p.datastr = null;
					endReq ();
				break;
				caso "local":
				case "clientside":
					beginReq ();
					ts.p.datatype = "local";
					var req = addLocalData ();
					addJSONData (req, ts.grid.bDiv, RCNT, npágina> 1, ajuste);
					. $ (Ts) triggerHan dler ("jqGridLoadComplete" [req]);
					if (lc) {lc.call (ts, req);}
					. $ (Ts) triggerHandler ("jqGridAfterLoadComplete" [req]);
					if (PVIS) {ts.grid.populateVisible ();}
					endReq ();
				break;
				}
			}
		},
		setHeadCheckBox = function (marcada) {
			$ ('# Cb_' + $. Jgrid.jqID (ts.p.id), ts.grid.hDiv) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", marcada);
			var fid = ts.p.frozenColumns? ts.p.id + "_FROZEN": "";
			if (fid) {
				$ ('# Cb_' + $. Jgrid.jqID (ts.p.id), ts.grid.fhDiv) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", marcada);
			}
		},
		setPager = function (PGID, tp) {
			/ / TBD - considerar fuga PGID com PGID = $ jgrid.jqID (PGID);.
			var setembro = "<td class='ui-pg-button ui-state-disabled' style='width:4px;'> <span class='ui-separator'> </ span> </ td>",
			pginp = "",
			pgl = "<table cellspacing='0' cellpadding='0' border='0' style='table-layout:auto;' class='ui-pg-table'> <tbody> <tr>",
			str = "", pgcnt, LFT, centavo, RGT, TWD, tdw, i,
			clearVals = function (onpaging) {
				var ret;
				Se {ret = ts.p.onPaging.call (ts, onpaging);} ($ isFunction (ts.p.onPaging).)
				if (ret === 'stop') {return false;}
				ts.p.selrow = null;
				if (ts.p.multiselect) {ts.p.selarrrow = []; setHeadCheckBox (false);}
				ts.p.savedRow = [];
				return true;
			};
			PGID = pgid.substr (1);
			tp = + "_" + PGID;
			pgcnt = "pg_" + PGID;
			LFT = PGID + "_Left"; cento = PGID + "_center"; RGT = PGID + "_right";
			$ ("#" + $. Jgrid.jqID (PGID))
			. Append ("<div id='"+pgcnt+"' class='ui-pager-control' role='group'> <table cellspacing = '0 'cellpadding = '0' border = '0 'class =' ​​ui mesa-pg-'style =' width: 100%; table-layout: fixed; height: 100%; "role = 'linha'> <tbody> <tr> <td id = '" + LFT + "' align = ' esquerda "> </ td> <td id='"+cent+"' align='center' style='white-space:pre;'> </ td> <td id = '" + RGT + "' align = ' direito "> </ td> </ tr> </ tbody> </ table> </ div>")
			. Attr ("dir", "l") / / definição explícita
			if (ts.p.rowList.length> 0) {
				str = "<td dir='"+dir+"'>";
				str + = "<selecione class='ui-pg-selbox' role='listbox'>";
				for (i = 0; i <ts.p.rowList.length; i + +) {
					str + = "<papel option = \" "valor = \" opção \ "+ ts.p.rowList [i] +" \ "" + ((ts.p.rowNum === ts.p.rowList [i ?]) "selecionado = \" escolhido \ "": "") + ">" + ts.p.rowList [i] + "</ option>";
				}
				str + = "</ select> </ td>";
			}
			if (dir === "RTL") {pgl + = str;}
			if (ts.p.pginput === true) {pginp = "<td dir='"+dir+"'>" + $ jgrid.format (ts.p.pgtext |. | "", "<class = input '-entrada ui-PG' type = tamanho 'text' = 'maxlength = '7' valor '2 = 'role =' '0 caixa de texto "/>", "<span id = 'sp_1_" + $. jgrid.jqID (PGID) + ""> </ span> ") +" </ td> ";}
			if (ts.p.pgbuttons === true) {
				var po = ["primeiro" + tp, "anterior" + tp, "ao lado" + tp, "último" + tp]; if (dir === "RTL") {po.reverse ();}
				pgl + = "<td id='"+po[0]+"' class='ui-pg-button ui-corner-all'> <span class='ui-icon ui-icon-seek-first'> </ span> </ td> ";
				pgl + = "<td id='"+po[1]+"' class='ui-pg-button ui-corner-all'> <span class='ui-icon ui-icon-seek-prev'> </ span> </ td> ";
				pgl + = pginp! == ""? setembro + + pginp setembro: "";
				pgl + = "<td id='"+po[2]+"' class='ui-pg-button ui-corner-all'> <span class='ui-icon ui-icon-seek-next'> </ span> </ td> ";
				pgl + = "<td id='"+po[3]+"' class='ui-pg-button ui-corner-all'> <span class='ui-icon ui-icon-seek-end'> </ span> </ td> ";
			} Else if (pginp == ""!) {Pgl + = pginp;}
			if (dir === "ltr") {pgl + = str;}
			pgl + = "</ tr> </ tbody> </ table>";
			if (ts.p.viewrecords === true) {$ ("# td" + PGID + "_" + ts.p.recordpos, "#" + pgcnt). append ("<div dir = '" + dir + " "style =" text-align: "+ ts.p.recordpos +" 'class = "ui-paginação-info'> </ div>");}
			$ ("# Td" + PGID + "_" + ts.p.pagerpos, "#" + pgcnt) append (PGL).;
			. tdw = $ (". ui-jqgrid") css ("font-size") | | "11px";
			$ (Document.body). Append ("<div id='testpg' class='ui-jqgrid ui-widget ui-widget-content' style='font-size:"+tdw+";visibility:hidden;'> </ div> ");
			... TWD = $ (PGL) clone () appendTo ("# testpg") largura ();
			. $ ("# Testpg") remove ();
			if (TWD> 0) {
				if (pginp == ""!) {TWD + = 50;} / / deve ser param
				. $ ("# Td" + PGID + "_" + ts.p.pagerpos, "#" + pgcnt) largura (TWD);
			}
			ts.p._nvtd = [];
			ts.p._nvtd [0] = TWD? Math.floor ((ts.p.width - TWD) / 2): Math.floor (ts.p.width / 3);
			ts.p._nvtd [1] = 0;
			pgl = null;
			$ ('. Ui-pg-selbox "," # "+ pgcnt). Bind (" mudança ", function () {
				if (! clearVals ('registros')) {return false;}
				ts.p.page = Math.round (ts.p.rowNum * (ts.p.page-1) / this.value-0.5) 1;
				ts.p.rowNum = this.value;
				if (ts.p.pager) {$ (, ts.p.pager 'ui-pg-selbox.') val (this.value);.}
				if (ts.p.toppager) {$ (, ts.p.toppager 'ui-pg-selbox.') val (this.value);.}
				preencher ();
				return false;
			});
			if (ts.p.pgbuttons === true) {
			$ ("-Pg-botão ui.", "#" + Pgcnt). Pairar (function () {
				if ($ this (). hasClass ('ui-state-deficientes ")) {
					this.style.cursor = 'default';
				} Else {
					. $ (This) addClass ('ui-state-pairar');
					this.style.cursor = 'ponteiro';
				}
			}, Function () {
				if (! $ (this). hasClass ('ui-estado desativado')) {
					. $ (This) removeClass ('ui-state-pairar');
					this.style.cursor = "default";
				}
			});
			$ ("# Primeiro" + $. Jgrid.jqID (tp) + ", # prev" jgrid.jqID (tp + $.) + ", Ao lado #" + $. Jgrid.jqID (tp) + ", # última "+ $. jgrid.jqID (tp)). click (function () {
				var cp = intNum (ts.p.page, 1),
				last = intNum (ts.p.lastpage, 1), selclick = false,
				fp = true, pp = true, np = true, lp = true;
				if (último === 0 | | última === 1) {fp = false; pp = false; np = false; lp = false;}
				else if (último> 1 && cp> = 1) {
					if (cp === 1) {fp = false; pp = false;}
					/ / Else if (cp> 1 && cp <passado) {}
					else if (cp === último) {np = false; lp = false;}
				} Else if (último> 1 && cp === 0) {np = false; lp = false; cp = passado-1;}
				(! clearVals (this.id)) if {return false;}
				if (this.id === 'primeiro' + tp && fp) {ts.p.page = 1; selclick = true;}
				if (this.id === 'prev' + tp && pp) {ts.p.page = (cp-1); selclick = true;}
				if (this.id === 'next' + tp && np) {ts.p.page = (cp +1); selclick = true;}
				if ('último' + tp && lp === this.id) {ts.p.page = passado; selclick = true;}
				if (selclick) {
					preencher ();
				}
				return false;
			});
			}
			if (ts.p.pginput === true) {
			$ ('Input.ui-pg-entrada "," # "+ pgcnt). Keypress (function (e) {
				chave var = e.charCode | | e.KeyCode | | 0;
				if (=== número 13) {
					if (! clearVals ('user')) {return false;}
					. $ (Este) val (intNum ($ (este) val (), 1).);
					ts.p.page = ($ (este). val ()> 0)? . $ (This) val (): ts.p.page;
					preencher ();
					return false;
				}
				devolver este;
			});
			}
		},
		MULTISORT = function (iCol, obj) {
			splas var, tipo = "", cm = ts.p.colModel, fs = false, sl, 
					selTh = ts.p.frozenColumns? . obj: ts.grid.headers [iCol] el, de modo = "";
			$ ("Span.ui-grid-ico-tipo", selTh) addClass ('ui-state-deficientes ").;
			. $ (SelTh) attr ("selecionado aria-", "false");

			if (cm [iCol]. lso) {
				if (cm [iCol]. === lso "asc") {
					. cm [iCol] lso + = "-desc";
					so = "desc";
				} Else if (cm [iCol]. === Lso "desc") {
					. cm [iCol] lso + = "-asc";
					so = "asc";
				} Else if (cm [iCol] lso === "asc-desc" |. |. Cm ​​[iCol] lso === "desc-asc") {
					. cm [iCol] lso = "";
				}
			} Else {
				. cm [iCol] lso = tão = cm [iCol] firstsortorder | | 'asc'.;
			}
			if (então) {
				$ ("Span.s-ico", selTh) show ().;
				$ ("Span.ui-icon-" + assim, selTh) removeClass ('ui-state-deficientes ").;
				. $ (SelTh) attr ("selecionado aria-", "true");
			} Else {
				if (! ts.p.viewsortcols [0]) {
					$ ("Span.s-ico", selTh) hide ().;
				}
			}
			ts.p.sortorder = "";
			$. Cada (cm, function (i) {
				if (this.lso) {
					if (i> 0 && fs) {
						tipo + = ",";
					}
					splas this.lso.split = ("-");
					. espécie + = cm [i] índice | | cm [i] nome.;
					tipo + = "" + splas [splas.length-1];
					fs = true;
					ts.p.sortorder = splas [splas.length-1];
				}
			});
			ls = sort.lastIndexOf (ts.p.sortorder);
			sort = sort.substring (0, ls);
			ts.p.sortname = espécie;
		},
		sortData = function (index, idxcol, recarregar, sor, obj) {
			Se {return;} (ts.p.colModel [idxcol] classificáveis!).
			if (ts.p.savedRow.length> 0) {return;}
			if (recarga!) {
				if (ts.p.lastsort === idxcol) {
					if (ts.p.sortorder === 'asc') {
						ts.p.sortorder = 'desc';
					} Else if (ts.p.sortorder 'desc' ===) {ts.p.sortorder 'asc';}
				.} Else {ts.p.sortorder = ts.p.colModel [idxcol] firstsortorder | | 'asc';}
				ts.p.page = 1;
			}
			if (ts.p.multiSort) {
				MULTISORT (idxcol, obj);
			} Else {
				if (sor) {
					if (ts.p.lastsort recarga === idxcol && ts.p.sortorder === sor &&!) {return;}
					ts.p.sortorder = sor;
				}
				var previousSelectedTh = ts.grid.headers [ts.p.lastsort]. el, newSelectedTh = ts.p.frozenColumns? obj:. ts.grid.headers [idxcol] el;

				$ ("Span.ui-grid-ico-tipo", previousSelectedTh) addClass ('ui-state-deficientes ").;
				. $ (PreviousSelectedTh) attr ("selecionado aria-", "false");
				if (ts.p.frozenColumns) {
					ts.grid.fhDiv.find ("span.ui-grid-ico-tipo") addClass ('ui-state-deficientes ").;
					ts.grid.fhDiv.find ("th") attr ("selecionado-ária", "false").;
				}
				$ ("Span.ui-icon-" + ts.p.sortorder, newSelectedTh) removeClass ('ui-state-deficientes ").;
				. $ (NewSelectedTh) attr ("selecionado aria-", "true");
				if (! ts.p.viewsortcols [0]) {
					if (ts.p.lastsort! == idxcol) {
						if (ts.p.frozenColumns) {
							. ts.grid.fhDiv.find ("span.s-ico") hide ();
						}
						$ ("Span.s-ico", previousSelectedTh) hide ().;
						$ ("Span.s-ico", newSelectedTh) show ().;
					}
				}
				index = index.substring (5 + ts.p.id.length + 1) / / ruim de ser mudado?!
				ts.p.sortname = ts.p.colModel [idxcol] índice | | índice.;
			}
			if ($ (ts). triggerHandler ("jqGridSortCol" [ts.p.sortname, idxcol, ts.p.sortorder]) === 'stop') {
				ts.p.lastsort = idxcol;
				retorno;
			}
			if ($. isFunction (ts.p.onSortCol)) {if (ts.p.onSortCol.call (ts, ts.p.sortname, idxcol, ts.p.sortorder) === 'stop') {ts. p.lastsort = idxcol; retorno;}}
			if (ts.p.datatype === "local") {
				if (ts.p.deselectAfterSort) {$ (ts) jqGrid ("resetSelection");.}
			} Else {
				ts.p.selrow = null;
				if (ts.p.multiselect) {setHeadCheckBox (false);}
				ts.p.selarrrow = [];
				ts.p.savedRow = [];
			}
			if (ts.p.scroll) {
				var sscroll = ts.grid.bDiv.scrollLeft;
				emptyRows.call (ts, true, false);
				ts.grid.hDiv.scrollLeft = sscroll;
			}
			if (ts.p.subGrid && ts.p.datatype === 'local') {
				$ ("Td.sgexpanded", "#" + $. Jgrid.jqID (ts.p.id)). Cada (function () {
					. $ (This) gatilho ("click");
				});
			}
			preencher ();
			ts.p.lastsort = idxcol;
			if (ts.p.sortname == índice && idxcol!) {ts.p.lastsort = idxcol;}
		},
		setColWidth = function () {
			var initwidth = 0, brd = $. jgrid.cell_width? 0: intNum (ts.p.cellLayout, 0), vc = 0, LVC, scw = intNum (ts.p.scrollOffset, 0), cw, hs = false, aw, gw = 0, cr;
			$. Cada (ts.p.colModel, function () {
				if (this.hidden === indefinido) {this.hidden = false;}
				if (ts.p.grouping && ts.p.autowidth) {
					. var ind = $ inArray (this.name, ts.p.groupingView.groupField);
					if (ind> = 0 && ts.p.groupingView.groupColumnShow.length> ind) {
						this.hidden = ts.p.groupingView.groupColumnShow [ind]!;
					}
				}
				this.widthOrg = cw = intNum (this.width, 0);
				if (this.hidden === false) {
					initwidth + = + brd cw;
					if (this.fixed) {
						gw + = + brd cw;
					} Else {
						vc + +;
					}
				}
			});
			if (isNaN (ts.p.width)) {
				ts.p.width = initwidth + (! (ts.p.shrinkToFit === false && isNaN (ts.p.height)) ACS: 0);
			}
			grid.width = ts.p.width;
			ts.p.tblwidth = initwidth;
			if (ts.p.shrinkToFit === false ts.p.forceFit && === true) {ts.p.forceFit = false;}
			if (ts.p.shrinkToFit === verdadeiro && vc> 0) {
				aw = grid.width-brd * vc-gw;
				if (isNaN! (ts.p.height)) {
					aw - = ACS;
					hs = true;
				}
				initwidth = 0;
				$. Cada (ts.p.colModel, function (i) {
					if (this.hidden === false &&! this.fixed) {
						cw = Math.round (aw * this.width / (ts.p.tblwidth-brd * vc-gw));
						this.width = cw;
						initwidth + = cw;
						lvc = i;
					}
				});
				cr = 0;
				if (hs) {
					if (grid.width-gw-(initwidth + * brd vc)! == ACS) {
						cr = grid.width-gw-(initwidth + brd * vc)-ACS;
					}
				} Else if (hs! && Math.abs (grid.width-gw-(initwidth + brd * vc))! == 1) {
					cr = grid.width-gw-(initwidth + brd * vc);
				}
				ts.p.colModel [LVC] largura + = cr.;
				ts.p.tblwidth = initwidth + cr + brd * vc + gw;
				if (ts.p.tblwidth> ts.p.width) {
					. ts.p.colModel [LVC] largura - = (ts.p.tblwidth - parseInt (ts.p.width, 10));
					ts.p.tblwidth = ts.p.width;
				}
			}
		},
		nextVisible = function (iCol) {
			var ret = iCol, j = iCol, i;
			for (i = iCol +1; i <ts.p.colModel.length; i + +) {
				if (ts.p.colModel [i]. escondido! == true) {
					j = i; break;
				}
			}
			voltar j-ret;
		},
		GetOffset = function (iCol) {
			var $ mil = $ (ts.grid.headers [iCol] el.), ret = [$ th.position () deixou + $ th.outerWidth ().];
			if (ts.p.direction === "RTL") {ret [0] = ts.p.width - ret [0];}
			ret [0] - = ts.grid.bDiv.scrollLeft;
			ret.push (.. $ (ts.grid.hDiv) posição () superior);
			ret.push ($ (ts.grid.bDiv) offset () top - $ (ts.grid.hDiv) offset () top + $ (ts.grid.bDiv) Altura ().....);
			voltar ret;
		},
		getColumnHeaderIndex = function (th) {
			. var i, headers = ts.grid.headers, ci = $ jgrid.getCellIndex (th);
			for (i = 0; i <headers.length; i + +) {
				if (th === cabeçalhos [i]. el) {
					ci = i;
					break;
				}
			}
			voltar ci;
		};
		this.p.id = this.id;
		if (. $ inArray (ts.p.multikey, SORTKEYS) === -1) {ts.p.multikey = false;}
		ts.p.keyIndex = false;
		ts.p.keyName = false;
		for (i = 0; i <ts.p.colModel.length; i + +) {
			. ts.p.colModel [i] = $ estender (true, {}, ts.p.cmTemplate, ts.p.colModel [i] template | | {}, ts.p.colModel [i].);
			if (ts.p.keyIndex === false && ts.p.colModel [i]. chave === true) {
				ts.p.keyIndex = i;
			}
		}
		ts.p.sortorder ts.p.sortorder.toLowerCase = ();
		.. Jgrid.cell_width $ = $ jgrid.cellWidth ();
		if (ts.p.grouping === true) {
			ts.p.scroll = false;
			ts.p.rownumbers = false;
			/ / Ts.p.subGrid = false; expiremental
			ts.p.treeGrid = false;
			ts.p.gridview = true;
		}
		if (this.p.treeGrid === true) {
			try {$ (this) jqGrid ("setTreeGrid");.} catch (_) {}
			if (ts.p.datatype == "local"!) {ts.p.localReader = {id: "_ID_"};}
		}
		if (this.p.subGrid) {
			try {$ (ts) jqGrid ("setSubGrid");.} catch (s) {}
		}
		if (this.p.multiselect) {
			this.p.colNames.unshift ("<origem role='checkbox' id='cb_"+this.p.id+"' class='cbox' type='checkbox'/>");
			this.p.colModel.unshift ({name: "cb", largura:. $ jgrid.cell_width ts.p.multiselectWidth + ts.p.cellLayout?: ts.p.multiselectWidth,sortable:false,resizable:false,hidedlg:true,search:false,align:'center',fixed:true});
		}
		if () {this.p.rownumbers
			this.p.colNames.unshift ("");
			this.p.colModel.unshift({name:'rn',width:ts.p.rownumWidth,sortable:false,resizable:false,hidedlg:true,search:false,align:'center',fixed:true});
		}
		ts.p.xmlReader = $. estender (true, {
			root: "linhas",
			linha: "linha",
			página: "linhas> página",
			no total: "linhas> total»,
			registra: "linhas> registros",
			repeatitems: verdadeiro,
			celular: "célula",
			id: "[id]",
			userdata: "userdata",
			subgrid: {raiz: "linhas", linha: "fileira", repeatitems: true, celular: "célula"}
		}, Ts.p.xmlReader);
		ts.p.jsonReader = $. estender (true, {
			root: "linhas",
			página: "page",
			no total: "total",
			registros: "registros",
			repeatitems: verdadeiro,
			celular: "célula",
			id: "id",
			userdata: "userdata",
			subgrid: {raiz: "linhas", repeatitems: true, celular: "célula"}
		}, Ts.p.jsonReader);
		ts.p.localReader = $. estender (true, {
			root: "linhas",
			página: "page",
			no total: "total",
			registros: "registros",
			repeatitems: false,
			celular: "célula",
			id: "id",
			userdata: "userdata",
			subgrid: {raiz: "linhas", repeatitems: true, celular: "célula"}
		}, Ts.p.localReader);
		if (ts.p.scroll) {
			ts.p.pgbuttons = false; ts.p.pginput = false; ts.p.rowList = [];
		}
		if (ts.p.data.length) {refreshIndex ();}
		var thead = "<thead> <tr class='ui-jqgrid-labels' role='rowheader'>",
		tdc, IDN, w, res, classificar
		td, ptr, tbody, imgs, iac = "", idc = "", sortarr = [], sortord = [], sotmp = [];
		if (ts.p.shrinkToFit === verdadeiro && ts.p.forceFit === true) {
			for (i = ts.p.colModel.length-1; i> = 0; i -) {
				if (ts.p.colModel! [i]. oculto) {
					ts.p.colModel [i] redimensionável = false.;
					break;
				}
			}
		}
		if (ts.p.viewsortcols [1] === 'horizontal') {iac = "ui-i-asc"; idc = "ui-i-desc";}
		TDC = isMSIE? "Class =" ui-th-div-ou seja, "": "";
		imgs = "<span class='s-ico' style='display:none'> <span class = tipo 'asc' = 'ui-grid-ico-tipo ui-icon-asc" + iac + "ui-state- desativada ui-ui-ícone ícone de triângulo-1-n ui-tipo-"+ dir +" '> </ span> ";
		imgs + = "<span sort = classe 'desc' = 'ui-grid-ico-tipo ui-icon-desc" + idc + "ui-state-disabled ui-icon ui-icon-triângulo-1-s ui-tipo - "+ dir +" '> </ span> </ span> ";
		if (ts.p.multiSort) {
			sortarr = ts.p.sortname.split (",");
			for (i = 0; i <sortarr.length; i + +) {
				.. sotmp = $ trim (sortarr [i]) split ("");
				. sortarr [i] = $ trim (sotmp [0]);
				sortord [i] = sotmp [1]? . $ Trim (sotmp [1]): ts.p.sortorder | | "asc";
			}
		}
		for (i = 0; i <this.p.colNames.length; i + +) {
			var tooltip = ts.p.headertitles? (. "Title = \" "+ $ jgrid.stripHtml (ts.p.colNames [i]) +" \ ""): "";
			thead + = "<th id = '" + ts.p.id + "_" + ts.p.colModel [i]. nome + "' role = class 'columnheader' = 'ui-state-default ui-th-coluna ui-th-"+ dir +" '"+ dica +"> ";
			. idn = ts.p.colModel [i] índice | | ts.p.colModel [i] nome.;
			thead + = "<div id='jqgh_"+ts.p.id+"_"+ts.p.colModel[i].name+"' "+tdc+">" + ts.p.colNames [i];
			if (ts.p.colModel [i] largura!). {ts.p.colModel [i] width = 150;.}
			else {ts.p.colModel [i] width = parseInt (ts.p.colModel [i] largura de 10.);.}
			if (typeof ts.p.colModel [i] == título "boolean".!) {ts.p.colModel [i] title = true;.}
			. ts.p.colModel [i] lso = "";
			if (IDN === ts.p.sortname) {
				ts.p.lastsort = i;
			}
			if (ts.p.multiSort) {
				sotmp = $ inArray (IDN, sortarr).;
				if (sotmp! == -1) {
					ts.p.colModel [i] = lso sortord [sotmp].;
				}
			}
			thead + = imgs + "</ div> </ th>";
		}
		thead + = "</ tr> </ thead>";
		imgs = null;
		. $ (This) append (thead);
		$ ("Thead tr: primeiro th",this).hover(function(){$(this).addClass('ui-state-hover');},function(){$(this).removeClass('ui-state-hover');});
		if (this.p.multiselect) {
			var emp = [], chk;
			$ ('# Cb_' + $. Jgrid.jqID (ts.p.id), this). Bind ('click', function () {
				ts.p.selarrrow = [];
				var froz = ts.p.frozenColumns === verdade? ts.p.id + "_FROZEN": "";
				if (this.checked) {
					$ (Ts.rows). Cada (function (i) {
						if (i> 0) {
							if (! $ (this). hasClass ("ui-subgrid") &&! $ (this). hasClass ("jqgroup") &&! $ (this). hasClass ('ui-state-deficientes ")) {
								$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + $. Jgrid.jqID (this.id)) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", true);
								$ (This) addClass ("ui-state-destaque") attr ("selecionado-ária", "true")..;  
								ts.p.selarrrow.push (this.id);
								ts.p.selrow = this.id;
								if (froz) {
									$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + $. Jgrid.jqID (this.id), ts.grid.fbDiv) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", true);
									$ AddClass ("ui-state-destaque") ("#" + $ jgrid.jqID (this.id), ts.grid.fbDiv.).;
								}
							}
						}
					});
					chk = true;
					emp = [];
				}
				else {
					$ (Ts.rows). Cada (function (i) {
						if (i> 0) {
							if (! $ (this). hasClass ("ui-subgrid") &&! $ (this). hasClass ('ui-state-deficientes ")) {
								$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + $. Jgrid.jqID (this.id)) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", false);
								$ (This) removeClass ("ui-state-destaque") attr ("selecionado-ária", "false")..;
								emp.push (this.id);
								if (froz) {
									$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + $. Jgrid.jqID (this.id), ts.grid.fbDiv) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", false);
									$ RemoveClass ("ui-state-destaque") ("#" + $ jgrid.jqID (this.id), ts.grid.fbDiv.).;
								}
							}
						}
					});
					ts.p.selrow = null;
					chk = false;
				}
				. $ (Ts) triggerHandler ("jqGridSelectAll" [chk ts.p.selarrrow: emp, chk]);
				Se {ts.p.onSelectAll.call (ts, chk ts.p.selarrrow?: emp, chk);} ($ isFunction (ts.p.onSelectAll).)
			});
		}

		if (ts.p.autowidth === true) {
			. var pw = $ (por exemplo) innerWidth ();
			ts.p.width = pw> 0? PW: 'nw';
		}
		setColWidth ();
		$ (Por exemplo). Css ("width", grid.width + "px"). Append ("<div class='ui-jqgrid-resize-mark' id='rs_m"+ts.p.id+"'> & # 160; </ div> ");
		. $ (Gv) css ("width", grid.width + "px");
		thead = $ ("thead: em primeiro lugar", ts). chegar (0);
		var tfoot = "";
		if (ts.p.footerrow) {tfoot + = "<papel table = estilo 'grid' = 'width:" + ts.p.tblwidth + "px" class = "ui-jqgrid-ftable' cellspacing = '0 cellpadding ' = 'border = '0' '0> <tr <tbody> role='row' class='ui-widget-content footrow footrow-"+dir+"'> ";}
		var tr = $ ("tr: em primeiro lugar", thead),
		firstr = "<tr class='jqgfirstrow' role='row' style='height:auto'>";
		ts.p.disableClick = false;
		$ ("Th", THR). Cada (function (j) {
			w = ts.p.colModel [j] largura.;
			if (ts.p.colModel [j] redimensionável === indefinido.) {ts.p.colModel [j] redimensionável = true;.}
			if (ts.p.colModel [j]. redimensionável) {
				res = document.createElement ("span");
				$ (Res). Html (""). AddClass ('ui-ui jqgrid-redimensionar-jqgrid-redimensionar-' + dir)
				. Css ("cursor", "col-resize");
				. $ (This) addClass (ts.p.resizeclass);
			} Else {
				res = "";
			}
			. $ (This) css ("width", w + "px") preceder (res).;
			res = null;
			var hdcol = "";
			if (ts.p.colModel [j]. oculto) {
				. $ (This) css ("display", "none");
				hdcol = "display: none;"
			}
			firstr + = "<td role='gridcell' style='height:0px;width:"+w+"px;"+hdcol+"'> </ td>";
			grid.headers [j] = {width: w, el: esta};
			sort = ts.p.colModel [j] classificáveis.;
			if (typeof classificar == 'boolean'!) {ts.p.colModel [j] classificáveis ​​= true;. sort = true;}
			. var nm = ts.p.colModel [j] nome;
			if ((nm === 'cb' | | nm === 'subgrid' | | nm === 'rn')) {
				if (ts.p.viewsortcols [2]) {
					$ ("> Div", this) addClass ('ui-jqgrid-classificável ").;
				}
			}
			if (tipo) {
				if (ts.p.multiSort) {
					if (ts.p.viewsortcols [0]) {
						. $ ("Div span.s-ico", this) show (); 
						if (ts.p.colModel [j]. lso) { 
							$ ("Div span.ui-icon-" + ts.p.colModel [j] lso, isso). RemoveClass ("ui-state-disabled").;
						}
					} Else if (ts.p.colModel [j]. Lso) {
						. $ ("Div span.s-ico", this) show ();
						$ ("Div span.ui-icon-" + ts.p.colModel [j] lso, isso). RemoveClass ("ui-state-disabled").;
					}
				} Else {
					if (ts.p.viewsortcols [0]) {$ ("div span.s-ico", this) show ();. if (j === ts.p.lastsort) {$ ("div span.ui -icon-"+ ts.p.sortorder, this) removeClass (." ui-state-disabled ");}}
					else if (j === ts.p.lastsort) {$ ("div span.s-ico", this) show ();. $ ("div span.ui-icon-" + ts.p.sortorder, isso) removeClass ("ui-state-disabled");.}
				}
			}
			if (ts.p.footerrow) {tfoot + = "<td role='gridcell' "+formatCol(j,0,'', null,'', false)+"> </ td>" ;}
		}). Mousedown (function (e) {
			if ($ (e.target) mais próximo ("th> span.ui-jqgrid-resize") comprimento == 1..!) {return;}
			var ci = getColumnHeaderIndex (this);
			if (ts.p.forceFit === true) {ts.p.nv = nextVisible (ci);}
			grid.dragStart (ci, e, GetOffset (ci));
			return false;
		}). Click (function (e) {
			if (ts.p.disableClick) {
				ts.p.disableClick = false;
				return false;
			}
			var s = "th> div.ui-jqgrid-classificável", r, d;
			if (ts.p.viewsortcols [2]!) {s = "th> div> span> span.ui-grid-ico-tipo";}
			var t = $ (e.target) mais próximo (s).;
			if (t.length == 1!) {return;}
			var ci;
			if (ts.p.frozenColumns) {
				. var tid = $ (this) [0] id.substring (ts.p.id.length + 1);
				$ (Ts.p.colModel). Cada (function (i) {
					if (this.name tid ===) {
						ci = i; return false;
					}
				});
			} Else {
				ci = getColumnHeaderIndex (this);
			}
			se {r = true; d = t.attr ("tipo");} (ts.p.viewsortcols [2]!)
			if (ci! = null) {
				sortData (isso esta $ ('div',) [0] id, ci, r, d,.);
			}
			return false;
		});
		if ($ ts.p.sortable &&. fn.sortable) {
			try {
				. $ (Ts) jqGrid ("sortableColumns", THR);
			} Catch (e) {}
		}
		if (ts.p.footerrow) {tfoot + = "</ tr> </ tbody> </ table>";}
		firstr + = "</ tr>";
		tbody = document.createElement ("tbody");
		this.appendChild (tbody);
		. $ (This) addClass ('ui-jqgrid-btable') append (firstr).;
		firstr = null;
		var hTable = $ ("estilo <classe de tabela = 'ui-jqgrid-htable' = 'width:" + ts.p.tblwidth + "px" role =' grid 'aria-labelledby =' gbox_ "+ this.id +" ' cellspacing = '0 'cellpadding = '0' border = '0 '> </ table> "). anexar (thead),
		hg = (ts.p.caption && ts.p.hiddengrid === true)? verdadeiro: false,
		hb = $ ("<div class='ui-jqgrid-hbox" + (dir==="rtl" "-rtl": "" )+"'> </ div>");
		thead = null;
		grid.hDiv = document.createElement ("div");
		$ (Grid.hDiv)
			. Css ({width: grid.width + "px"})
			. AddClass ("ui-jqgrid-hdiv-ui-state default")
			. Anexar (HB);
		. $ (Hb) append (hTable);
		hTable = null;
		if (hg) {$ (grid.hDiv) hide ();.}
		if (ts.p.pager) {
			/ / TBD - escapar ts.p.pager aqui?
			if (typeof ts.p.pager === "string") {if (ts.p.pager.substr (0,1)! == "#") {ts.p.pager = "#" + ts. p.pager;}}
			else {ts.p.pager = "#" + $ (ts.p.pager) attr ("id");.}
			... $ (Ts.p.pager) css ({width: grid.width + "px"}) addClass ('ui-ui jqgrid-pager-canto inferior ui-state-default') appendTo (por exemplo);
			if (hg) {$ (ts.p.pager) hide ();.}
			setPager (ts.p.pager,'');
		}
		if (ts.p.cellEdit === ts.p.hoverrows && falsos === true) {
		$ (Ts). Bind ('mouseover', function (e) {
			ptr = $ (e.target) mais próximo ("tr.jqgrow").;
			if ($ (PTR). attr ("class")! == "ui-subgrid") {
				$ (PTR) addClass ("ui-state-pairar").;
			}
		}). Ligar ('mouseout', function (e) {
			ptr = $ (e.target) mais próximo ("tr.jqgrow").;
			$ (PTR) removeClass ("ui-state-pairar").;
		});
		}
		var ri, ci, tdHtml;
		$ (Ts). Antes (grid.hDiv). Click (function (e) {
			TD = e.target;
			ptr = $ (td, ts.rows) mais próximo ("tr.jqgrow").;
			if ($ (PTR) comprimento === 0 |. |. ptr [0] className.indexOf ('ui-estado desativado')> -1 | |. ($ (td, ts) mais próximo ("table.ui -jqgrid-btable ") attr ('id') |. |.'') substituir (" _FROZEN "," ") == ts.id) {!
				devolver este;
			}
			var scb = $ (td). hasClass ("cbox"),
			CSEL = $ (ts) triggerHandler ("jqGridBeforeSelectRow" [ptr [0] id, e.]).;
			CSEL = (CSEL === false | | CSEL === 'stop')? false: true;
			if (CSEL && $ isFunction (ts.p.beforeSelectRow).) {CSEL = ts.p.beforeSelectRow.call (ts, ptr [0] id, e.);}
			if (td.tagName === 'A' | | ((td.tagName === 'INPUT' | | td.tagName === 'TEXTAREA' | | td.tagName === 'OPÇÃO' | | td. ! tagName === 'SELECT') && scb)) {return;}
			if (CSEL === true) {
				ri = ptr [0] id.;
				. ci = $ jgrid.getCellIndex (td);
				.. tdHtml = $ (td) mais próximo ("td, th") html ();
				. $ (Ts) triggerHandler ("jqGridCellSelect" [ri, ci, tdHtml, e]);
				if ($. isFunction (ts.p.onCellSelect)) {
					ts.p.onCellSelect.call (ts, ri, ci, tdHtml, e);
				}
				if (ts.p.cellEdit === true) {
					if (ts.p.multiselect && scb) {
						. $ (Ts) jqGrid ("setSelection", ri, é verdade, e);
					} Else {
						ri = ptr [0] rowIndex.;
						try {$ (ts) jqGrid ("editCell", ri, ci, true);.} catch (_) {}
					}
				} Else if (ts.p.multikey!) {
					if (ts.p.multiselect && ts.p.multiboxonly) {
						if (scb) {$ (ts) jqGrid ("setSelection", ri, é verdade, e);.}
						else {
							var FRZ = ts.p.frozenColumns? ts.p.id + "_FROZEN": "";
							$ (Ts.p.selarrrow). Cada (function (i, n) {
								. var trid = $ (ts) jqGrid ('getGridRowById', n);
								$ (Trid) removeClass ("ui-state-destaque").;
								$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + $. Jgrid.jqID (n)) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", false);
								if (frz) {
									. $ (.. "#" + $ Jgrid.jqID (n), "#" + $ jgrid.jqID (frz)) removeClass ("ui-state-destaque");
									$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + $. Jgrid.jqID (n), "#" + $. Jgrid.jqID (frz)) [ts.p . useProp? 'Sustentar': 'attr'] ("checked", false);
								}
							});
							ts.p.selarrrow = [];
							. $ (Ts) jqGrid ("setSelection", ri, é verdade, e);
						}
					} Else {
						. $ (Ts) jqGrid ("setSelection", ri, é verdade, e);
					}
				} Else {
					if (e [ts.p.multikey]) {
						. $ (Ts) jqGrid ("setSelection", ri, é verdade, e);
					} Else if (ts.p.multiselect && scb) {
						scb = $ ("# jqg_" + $ jgrid.jqID (ts.p.id) + "_" + ri.) é (": checked").;
						$ ("# Jqg_" + $. Jgrid.jqID (ts.p.id) + "_" + ri) [ts.p.useProp? 'Sustentar': 'attr'] ("checked", scb);
					}
				}
			}
		}). Bind ('reloadGrid', function (e, opta) {
			if (ts.p.treeGrid === true) {ts.p.datatype = ts.p.treedatatype;}
			if (opta && opts.current) {
				ts.grid.selectionPreserver (ts);
			}
			if (ts.p.datatype === "local") {$ (ts) jqGrid ("resetSelection");. if (ts.p.data.length) {refreshIndex ();}}
			else if (ts.p.treeGrid!) {
				ts.p.selrow = null;
				if (ts.p.multiselect) {ts.p.selarrrow = []; setHeadCheckBox (false);}
				ts.p.savedRow = [];
			}
			if (ts.p.scroll) {emptyRows.call (ts, true, false);}
			if (opta && opts.page) {
				página var = opts.page;
				if (página> ts.p.lastpage) {page = ts.p.lastpage;}
				if (página <1) {page = 1;}
				ts.p.page = página;
				if (ts.grid.prevRowHeight) {
					ts.grid.bDiv.scrollTop = (página - 1) * ts.grid.prevRowHeight * ts.p.rowNum;
				} Else {
					ts.grid.bDiv.scrollTop = 0;
				}
			}
			if (ts.grid.prevRowHeight && ts.p.scroll) {
				excluir ts.p.lastpage;
				ts.grid.populateVisible ();
			} Else {
				ts.grid.populate ();
			}
			if (ts.p._inlinenav === true) {$ (ts) jqGrid ('showAddEditButtons');.}
			return false;
		})
		. Dblclick (function (e) {
			TD = e.target;
			ptr = $ (td, ts.rows) mais próximo ("tr.jqgrow").;
			if ($ (PTR) comprimento === 0.) {return;}
			ri = ptr [0] rowIndex.;
			. ci = $ jgrid.getCellIndex (td);
			. $ (Ts) triggerHandler ("jqGridDblClickRow", [$ (PTR) attr ("id"), ri, ci, e.]);
			Se {ts.p.ondblClickRow.call (ts, $ (PTR) attr ("id"), ri, ci, e.);} ($ isFunction (ts.p.ondblClickRow).)
		})
		. Bind ('contextmenu', function (e) {
			TD = e.target;
			ptr = $ (td, ts.rows) mais próximo ("tr.jqgrow").;
			if ($ (PTR) comprimento === 0.) {return;}
			se {$ (ts) jqGrid ("setSelection", ptr [0] id, é verdade, e.).;} (ts.p.multiselect!)
			ri = ptr [0] rowIndex.;
			. ci = $ jgrid.getCellIndex (td);
			. $ (Ts) triggerHandler ("jqGridRightClickRow", [$ (PTR) attr ("id"), ri, ci, e.]);
			Se {ts.p.onRightClickRow.call (ts, $ (PTR) attr ("id"), ri, ci, e.);} ($ isFunction (ts.p.onRightClickRow).)
		});
		grid.bDiv = document.createElement ("div");
		if (isMSIE) {if (String (ts.p.height) toLowerCase () === "auto".) {ts.p.height = "100%";}}
		$ (Grid.bDiv)
			. Append ($ ('<div style = "position: relative;' + (isMSIE && $ jgrid.msiever () <8.?" Altura: 0,01%; ":" ") +" "> </ div> ' ). append ('<div> </ div>'). anexar (this))
			. AddClass ("ui-jqgrid-bdiv")
			. Css ({height: ts.p.height + (isNaN (ts.p.height) "": "px"), largura: (grid.width) + "px"})
			. Rolagem (grid.scrollGrid);
		. $ ("Table: em primeiro lugar", grid.bDiv) css ({width: ts.p.tblwidth + "px"});
		if (! $. support.tbody) {/ / IE
			if ($ this ("tbody") comprimento === 2.) {$ ("tbody: gt (0)", this). remove ();}
		}
		if (ts.p.multikey) {
			if ($. jgrid.msie) {
				. $ (Grid.bDiv) bind ("selectstart", function () {return false;});
			} Else {
				. $ (Grid.bDiv) bind ("mousedown", function () {return false;});
			}
		}
		if (hg) {$ (grid.bDiv) hide ();.}
		grid.cDiv = document.createElement ("div");
		var arf = ts.p.hidegrid === verdade? $ ("<a Role='link' class='ui-jqgrid-titlebar-close HeaderButton' />"). Pairar (
			function () {arf.addClass ('ui-state-pairar');}
			function () {arf.removeClass ('ui-state-pairar');})
		. Append ("<span class='ui-icon ui-icon-circle-triangle-n'> </ span>") css ((dir === "RTL" "esquerda":.? "Direito"), "0px"): "";
		$ (Grid.cDiv). Anexar (IRA). Append ("<span class='ui-jqgrid-title'>" + ts.p.caption + "</ span>")
		. AddClass ("ui-ui jqgrid-titlebar-jqgrid-caption" + (dir === "RTL" "-rtl": "") + "ui-widget-header ui-corner-top ui-helper-clearfix ");
		$ (Grid.cDiv) insertBefore (grid.hDiv).;
		if (ts.p.toolbar [0]) {
			grid.uDiv = document.createElement ("div");
			if (ts.p.toolbar [1] === "top") {$ (grid.uDiv) insertBefore (grid.hDiv);.}
			else if (ts.p.toolbar [1] === "bottom") {$ (grid.uDiv) insertAfter (grid.hDiv);.}
			if (ts.p.toolbar [1] === "ambos") {
				grid.ubDiv = document.createElement ("div");
				.. $ (Grid.uDiv) addClass ("ui-state-default ui-userdata") attr ("id", "t_" + this.id) insertBefore (grid.hDiv).;
				.. $ (Grid.ubDiv) addClass ("ui-state-default ui-userdata") attr ("id", "tb_" + this.id) insertAfter (grid.hDiv).;
				if (hg) {$ (grid.ubDiv) hide ();.}
			} Else {
				... $ (Grid.uDiv) largura (grid.width) addClass ("ui-state-default ui-userdata") attr ("id", "t_" + this.id);
			}
			if (hg) {$ (grid.uDiv) hide ();.}
		}
		if (ts.p.toppager) {
			. ts.p.toppager = $ jgrid.jqID (ts.p.id) + "_toppager";
			grid.topDiv = $ ("<div id='"+ts.p.toppager+"'> </ div>") [0];
			ts.p.toppager = "#" + ts.p.toppager;
			.. $ (Grid.topDiv) addClass ('ui-jqgrid-toppager ui-state-default') largura (grid.width) insertBefore (grid.hDiv).;
			setPager (ts.p.toppager, '_t');
		}
		if (ts.p.footerrow) {
			grid.sDiv = $ ("<div class='ui-jqgrid-sdiv'> </ div>") [0];
			hb = $ ("<div class='ui-jqgrid-hbox"+(dir==="rtl"?"-rtl":"")+"'> </ div>");
			.. $ (Grid.sDiv) append (hb) largura (grid.width) insertAfter (grid.hDiv).;
			. $ (Hb) append (tfoot);
			. grid.footers = $ (". ui-jqgrid-ftable", grid.sDiv) [0] linhas [0] células.;
			if () {ts.p.rownumbers. grid.footers [0] className = 'ui-state-default jqgrid-rownum';}
			if (hg) {$ (grid.sDiv) hide ();.}
		}
		hb = null;
		if (ts.p.caption) {
			var tdt = ts.p.datatype;
			if (ts.p.hidegrid === true) {
				$ (". Ui-jqgrid-titlebar de perto", grid.cDiv). Click (function (e) {
					var onHdCl = $. isFunction (ts.p.onHeaderClick),
					elems = ". ui-jqgrid-bdiv,. ui-jqgrid-hdiv,. ui-jqgrid-pager,. ui-jqgrid-sdiv",
					balcão, auto = this;
					if (ts.p.toolbar [0] === true) {
						if (ts.p.toolbar [1] === 'tanto') {
							. elems + = ', #' + $ (grid.ubDiv) attr ('id');
						}
						. elems + = ', #' + $ (grid.uDiv) attr ('id');
					}
					(. elems, "# gview_" + $ jgrid.jqID (ts.p.id)) contador = $ length.;

					if (ts.p.gridstate === 'visível') {
						$ (Elems, "# gbox_" + $. Jgrid.jqID (ts.p.id)). SlideUp ("rápido", function () {
							contador -;
							if (contador === 0) {
								. $ ("Span", self) removeClass ("ui-icon-círculo-triângulo-n") addClass ("ui-icon-círculo-triângulo-s").;
								ts.p.gridstate = 'escondido';
								if ($ ("# gbox_" + $. jgrid.jqID (ts.p.id)). hasClass ("ui-redimensionável")) {$ (". ui-redimensionável-handle", "# gbox_" + $ .. jgrid.jqID (ts.p.id)) hide ();}
								. $ (Ts) triggerHandler ("jqGridHeaderClick" [ts.p.gridstate, e]);
								if (onHdCl) {if {ts.p.onHeaderClick.call (ts, ts.p.gridstate, e) (hg!);}}
							}
						});
					} Else if (ts.p.gridstate === 'escondido') {
						$ (Elems, "# gbox_" + $. Jgrid.jqID (ts.p.id)). SlideDown ("rápido", function () {
							contador -;
							if (contador === 0) {
								. $ ("Span", self) removeClass ("ui-icon-círculo-triângulo-s") addClass ("ui-icon-círculo-triângulo-n").;
								if (hg) {ts.p.datatype = tdt; preencher (); hg = false;}
								ts.p.gridstate = 'visível';
								if ($ ("# gbox_" + $. jgrid.jqID (ts.p.id)). hasClass ("ui-redimensionável")) {$ (". ui-redimensionável-handle", "# gbox_" + $ .. jgrid.jqID (ts.p.id)) show ();}
								. $ (Ts) triggerHandler ("jqGridHeaderClick" [ts.p.gridstate, e]);
								if (onHdCl) {if {ts.p.onHeaderClick.call (ts, ts.p.gridstate, e) (hg!);}}
							}
						});
					}
					return false;
				});
				if (hg) {ts.p.datatype = "local", (". ui-jqgrid-titlebar de perto", grid.cDiv). $ gatilho ("click");}
			}
		.} Else {$ (grid.cDiv) hide ();}
		$ (Grid.hDiv). Após (grid.bDiv)
		. Mousemove (function (e) {
			if (grid.resizing) {grid.dragMove (e); return false;}
		});
		$ (". Ui-jqgrid rótulos", grid.hDiv) Bind ("selectstart", function () {return false;}).;
		$ (Document). Bind ("mouseup.jqGrid" + ts.p.id, function () {
			if (grid.resizing) {grid.dragEnd (); return false;}
			return true;
		});
		ts.formatCol = formatCol;
		ts.sortData = sortData;
		ts.updatepager = updatepager;
		ts.refreshIndex = refreshIndex;
		ts.setHeadCheckBox = setHeadCheckBox;
		ts.constructTr = constructTr;
		ts.formatter = function (ROWID, cellval, colpos, rwdat, act) {return formatador (ROWID, cellval, colpos, rwdat, ato);};
		. $ Estender (grade, {preencher: preencher, emptyRows: emptyRows, beginReq: beginReq, endReq: endReq});
		this.grid = grade;
		ts.addXmlData = function (d) {addXmlData (d, ts.grid.bDiv);};
		ts.addJSONData = function (d) {addJSONData (d, ts.grid.bDiv);};
		. this.grid.cols = this.rows [0] células;
		. $ (Ts) triggerHandler ("jqGridInitGrid");
		Se {ts.p.onInitGrid.call (ts);} ($ isFunction (ts.p.onInitGrid).)

		preencher (); ts.p.hiddengrid = false;
	});
};
$. Jgrid.extend ({
	getGridParam: function (pName) {
		var $ t = this [0];
		if ($ t | | $ t.grid!) {return;}
		(! pName) se {return $ tp;}
		return $ tp [pName]! == indefinido? $ Tp [pName]: null;
	},
	setGridParam: function (newParams) {
		voltar this.each (function () {
			if (typeof this.grid && 'objeto' newParams ===) {. $ estender (true, this.p, newParams);}
		});
	},
	getGridRowById: function (rowid) {
		var linha;
		this.each (function () {
			try {
				/ / Linha = this.rows.namedItem (rowid);
				var i = this.rows.length;
				while (i -) {
					if (rowid.toString () === this.rows [i]. id) {
						carreira = this.rows [i];
						break;
					}
				}
			} Catch (e) {
				row = $ (this.grid.bDiv) encontrar. ("#" + $ jgrid.jqID (rowid).);
			}
		});
		retornar linha;
	},
	getDataIDs: function () {
		var ids = [], i = 0, len, j = 0;
		this.each (function () {
			len = this.rows.length;
			if (len && len> 0) {
				while (i <len) {
					if ($ (this.rows [i]). hasClass ('jqgrow')) {
						. ids [j] = this.rows [i] id;
						j + +;
					}
					i + +;
				}
			}
		});
		voltar ids;
	},
	setSelection: function (seleção, onsr, e) {
		voltar this.each (function () {
			var $ t = esta, stat, pt, ner, ia, TPSR, fid;
			if (seleção === indefinido) {return;}
			onsr = onsr === false? false: true;
			pt = $ ($ t) jqGrid ('getGridRowById', seleção).;
			Se {return;} (pt | | | pt.className | pt.className.indexOf ('ui-state-deficientes ")> -1!)
			função scrGrid (iR) {
				var pc = $ ($ t.grid.bDiv) [0]. clientHeight,
				st = $ ($ t.grid.bDiv) [0]. scrollTop,
				rpos = $ ($ t.rows [IR]). posição (). topo
				rh = $ t.rows [iR] clientHeight.;
				if (rpos + rh> = ch + st) {$ ($ t.grid.bDiv) [0] = scrollTop rpos-(ch + st) + rh + rua;.}
				else if (rpos <ch + ST) {
					if (rpos <st) {
						$ ($ T.grid.bDiv) [0] = scrollTop rpos.;
					}
				}
			}
			if ($ tpscrollrows === true) {
				ner = $ ($ t) jqGrid ('getGridRowById', seleção) rowIndex..;
				if (ner> = 0) {
					scrGrid (ner);
				}
			}
			if ($ tpfrozenColumns === true) {
				fid = $ TPID + "_FROZEN";
			}
			if (! $ tpmultiselect) {	
				if (pt.className! == "ui-subgrid") {
					if ($ tpselrow! == pt.id) {
						$ (. $ ($ T) jqGrid ('getGridRowById', $ tpselrow)) removeClass ("ui-state-destaque") attr ({"aria-selecionados":.. "False", "tabindex": "-1 "});
						... $ (Pt) addClass ("ui-state-destaque") attr ({"aria-selecionados": "true", "tabindex": "0"}) ;/ / foco ();
						if (fid) {
							$ ("#" + $ Jgrid.jqID ($ tpselrow), "#" + $ jgrid.jqID (FID).). RemoveClass ("ui-state-destaque").;
							$ AddClass ("ui-state-destaque") ("#" + $ jgrid.jqID (seleção), "#" + $ jgrid.jqID (FID)..).;
						}
						status = true;
					} Else {
						status = false;
					}
					$ Tpselrow = pt.id;
					if (onsr) { 
						. $ ($ T) triggerHandler ("jqGridSelectRow" [pt.id, stat, e]);
						if ($ tponSelectRow) {$ tponSelectRow.call ($ t, pt.id, stat, e);}
					}
				}
			} Else {
				/ / Checkbox selectAll unselect quando desmarcando uma linha específica
				$ T.setHeadCheckBox (false);
				$ Tpselrow = pt.id;
				. ia = $ inArray ($ tpselrow, $ tpselarrrow);
				if (ia === -1) {
					if (pt.className == "ui-subgrid!") {$ (pt) addClass ("ui-state-destaque") attr ("aria-selecionados", "true");..}
					status = true;
					$ Tpselarrrow.push ($ tpselrow);
				} Else {
					if (pt.className == "ui-subgrid!") {$ (pt) removeClass ("ui-state-destaque") attr ("aria-selecionados", "false");..}
					status = false;
					$ Tpselarrrow.splice (ia, 1);
					TPSR = $ tpselarrrow [0];
					$ Tpselrow = (TPSR === indefinido)? null: TPSR;
				}
				$ ("# Jqg_" + $. Jgrid.jqID ($ TPID) + "_" + $. Jgrid.jqID (pt.id)) [$ tpuseProp? 'Sustentar': 'attr'] ("checked", status);
				if (fid) {
					if (ia === -1) {
						$ AddClass ("ui-state-destaque") ("#" + $ jgrid.jqID (seleção), "#" + $ jgrid.jqID (FID)..).;
					} Else {
						$ ("#" + $ Jgrid.jqID (seleção), "#" + $ jgrid.jqID (FID).). RemoveClass ("ui-state-destaque").;
					}
					$ ("# Jqg_" + $. Jgrid.jqID ($ TPID) + "_" + $. Jgrid.jqID (seleção), "#" + $. Jgrid.jqID (FID)) [$ tpuseProp? 'Sustentar': 'attr'] ("checked", status);
				}
				if (onsr) {
					. $ ($ T) triggerHandler ("jqGridSelectRow" [pt.id, stat, e]);
					if ($ tponSelectRow) {$ tponSelectRow.call ($ t, pt.id, stat, e);}
				}
			}
		});
	},
	resetSelection: function (rowid) {
		voltar this.each (function () {
			var t = isso, sr, fid;
			if (tpfrozenColumns === true) {
				fid = TPID + "_FROZEN";
			}
			if (rowid! == undefined) {
				sr = rowid === tpselrow? tpselrow: rowid;
				$ ("#" + $ Jgrid.jqID (TPID) + "tbody: primeiro tr #".. + $ Jgrid.jqID (sr)).. RemoveClass ("ui-state-destaque") attr ("aria-selecionados "," false ");
				if (FID) {$ removeClass ("ui-state-destaque") ("#" + $ jgrid.jqID (sr), "#" + $ jgrid.jqID (FID)..);.}
				if (tpmultiselect) {
					$ ("# Jqg_" + $. Jgrid.jqID (TPID) + "_" + $. Jgrid.jqID (sr), "#" + $. Jgrid.jqID (TPID)) [tpuseProp? 'Sustentar': 'attr'] ("checked", false);
					if (FID) {$ ("# jqg_" jgrid.jqID (TPID) + "_" + $. jgrid.jqID (sr), "#" + $ + $.. jgrid.jqID (FID)) [tpuseProp? 'Sustentar': 'attr'] ("marcada", false);}
					t.setHeadCheckBox (false);
				}
				sr = null;
			} Else if (tpmultiselect!) {
				if (tpselrow) {
					$ ("#" + $ Jgrid.jqID (TPID) + "tbody: primeiro tr #".. + $ Jgrid.jqID (tpselrow)).. RemoveClass ("ui-state-destaque") attr ("aria-selecionados "," false ");
					if (FID) {$ removeClass ("ui-state-destaque") ("#" + $ jgrid.jqID (tpselrow), "#" + $ jgrid.jqID (FID)..);.}
					tpselrow = null;
				}
			} Else {
				$ (Tpselarrrow). Cada (function (i, n) {
					(. $ (T) jqGrid ('getGridRowById', n)) $ removeClass ("ui-state-destaque") attr ("selecionado-ária", "false")..;
					$ ("# Jqg_" + $. Jgrid.jqID (TPID) + "_" + $. Jgrid.jqID (n)) [tpuseProp? 'Sustentar': 'attr'] ("checked", false);
					if (fid) { 
						$ ("#" + $ Jgrid.jqID (n), "#" + $ jgrid.jqID (FID).). RemoveClass ("ui-state-destaque").; 
						$ ("# Jqg_" jgrid.jqID (TPID) + "_" + $. Jgrid.jqID (n), "#" + $ + $.. Jgrid.jqID (FID)) [tpuseProp? 'Sustentar': 'attr'] ("checked", false);
					}
				});
				t.setHeadCheckBox (false);
				tpselarrrow = [];
			}
			if (tpcellEdit === true) {
				if (parseInt (tpiCol, 10)> = 0 && parseInt (tpiRow, 10)> = 0) {
					$ ("Td: eq (" + tpiCol + ")", t.rows [tpiRow]) removeClass ("célula de edição ui-state-destaque");.
					$ (T.rows [tpiRow]) removeClass ("selecionado fileiras ui-state-pairar").;
				}
			}
			tpsavedRow = [];
		});
	},
	GetRowData: function (rowid) {
		res var = {}, resall, getall = false, len, j = 0;
		this.each (function () {
			var $ t = isso, nm, ind;
			if (rowid === indefinido) {
				getall = true;
				resall = [];
				len = $ t.rows.length;
			} Else {
				ind = $ ($ t) jqGrid ('getGridRowById ", rowid).;
				se {res de retorno;} (IND!)
				len = 2;
			}
			while (j <len) {
				if (getall) {ind = $ t.rows [j];}
				if ($ (ind). hasClass ('jqgrow')) {
					$ ('Td [role = "gridcell"] ", ind). Cada (function (i) {
						. nm = $ tpcolModel [i] nome;
						if (nm! == 'cb' && nm! == 'subgrid' && nm! == 'rn') {
							if ($ tptreeGrid === verdadeiro && nm === $ tpExpandColumn) {
								. res [nm] = $ jgrid.htmlDecode ($ ("útil: em primeiro lugar". isso,) html ());
							} Else {
								try {
									. res [nm] = $ unformat.call ($ t, este, {RowId: ind.id, colModel: $ tpcolModel [i]}, i);
								} Catch (e) {
									. res [nm] = $ jgrid.htmlDecode (. $ (this) html ());
								}
							}
						}
					});
					if (getall) {resall.push (res); res = {};}
				}
				j + +;
			}
		});
		voltar resall | | res;
	},
	delRowData: function (rowid) {
		sucesso var = false, rowInd, IA;
		this.each (function () {
			var $ t = this;
			rowInd = $ ($ t) jqGrid ('getGridRowById ", rowid).;
			if (! rowInd) {return false;}
				. $ (RowInd) remove ();
				tprecords $ -;
				Tpreccount $ -;
				$ T.updatepager (true, false);
				sucesso = true;
				if ($ tpmultiselect) {
					ia = $ inArray (rowid, $ tpselarrrow).;
					if (iA == -1!) {$ tpselarrrow.splice (ia, 1);}
				}
				if ($ tpmultiselect && $ tpselarrrow.length> 0) {
					Tpselrow $ = $ tpselarrrow [$ tpselarrrow.length-1];
				} Else {
					$ Tpselrow = null;
				}
			if ($ tpdatatype === 'local') {
				id = $ var. jgrid.stripPref ($ tpidPrefix, rowid),
				pos = $ tp_index [id];
				if (pos! == indefinido) {
					$ Tpdata.splice (pos, 1);
					T.refreshIndex $ ();
				}
			}
			if ($ tpaltRows === verdadeiro && sucesso) {
				var cn = $ tpaltclass;
				$ ($ T.rows). Cada (function (i) {
					if (i% 2 === 1) {$ (this) addClass (cn);.}
					else {$ (this) removeClass (cn);.}
				});
			}
		});
		retornar com êxito;
	},
	setRowData: function (rowid, dados, CSSp) {
		var nm, o sucesso = true, o título;
		this.each (function () {
			Se {return false;} (this.grid!)
			var t = isso, vl, ind, cp = typeof CSSp, lcdata = {};
			ind = $ (this) jqGrid ('getGridRowById ", rowid).;
			if (! ind) {return false;}
			se (dados) {
				try {
					$ (This.p.colModel). Cada (function (i) {
						nm = this.name;
						. var dval = $ jgrid.getAccessor (dados, nm);
						if (dval! == undefined) {
							lcdata [nm] = this.formatter && typeof this.formatter === 'string' && this.formatter === 'date'? . $ Unformat.date.call (t, dval, this): dval;
							vl = t.formatter (rowid, dval, i, dados, "editar");
							title = this.title? {. "Title": $ jgrid.stripHtml (vl)}: {};
							if (tptreeGrid === verdadeiro && nm === tpExpandColumn) {
								.. $ ("Td [role = 'gridcell']: eq (" + i + ")> intervalo: em primeiro lugar", ind) html (vl) attr (título);
							} Else {
								. $. ("Td [role = 'gridcell']: eq (" + i + ")", ind) html (vl) attr (título);
							}
						}
					});
					if (tpdatatype === 'local') {
						id = $ var. jgrid.stripPref (tpidPrefix, rowid),
						pos = tp_index [id], chave;
						if (tptreeGrid) {
							for (chave na tptreeReader) {
								if (tptreeReader.hasOwnProperty (chave)) {
									excluir lcdata [tptreeReader [chave]];
								}
							}
						}
						if (pos! == indefinido) {
							. tpdata [pos] = $ estender (true, tpdata [pos], lcdata);
						}
						lcdata = null;
					}
				} Catch (e) {
					sucesso = false;
				}
			}
			if (sucesso) {
				if (cp === 'string') {$ (ind) addClass (CSSp);.} else if (cp === 'objeto') {$ (ind) css (CSSp);.}
				$ (T) triggerHandler ("jqGridAfterGridComplete").;
			}
		});
		retornar com êxito;
	},
	addRowData: function (rowid, rdata, pos, src) {
		if (pos!) {pos = "último";}
		sucesso var = false, nm, linha, gi, si, ni, sind, I, V, prp = "", aradd, cnm, cn, dados, cm, id;
		if (rdata) {
			if ($. isArray (rdata)) {
				aradd = true;
				pos = "último";
				CNM = rowid;
			} Else {
				rdata = [rdata];
				aradd = false;
			}
			this.each (function () {
				var t = isso, DataLen = rdata.length;
				ni = tprownumbers === verdadeiros? 1: 0;
				gi = tpmultiselect === verdade? 1: 0;
				si = tpsubGrid === verdade? 1: 0;
				if (! aradd) {
					if (rowid == indefinido!) {rowid = String (rowid);}
					else {
						. rowid = $ jgrid.randId ();
						if (tpkeyIndex! == false) {
							. CNM = tpcolModel [tpkeyIndex + gi + si + ni] nome;
							if (rdata [0] [CNM] == indefinido!) {rowid = rdata [0] [CNM];}
						}
					}
				}
				cn = tpaltclass;
				var k = 0, possa = "", lcdata = {},
				ar = $. isFunction (tpafterInsertRow)? verdadeiro: false;
				enquanto (k <DataLen) {
					data = rdata [k];
					linha = [];
					if (aradd) {
						try {
							rowid = dados [CNM];
							if (rowid === indefinido) {
								. rowid = $ jgrid.randId ();
							}
						}
						catch (e) {. rowid = $ jgrid.randId ();}
						cna = tpaltRows === verdade? % (T.rows.length-1) 2 0 ===? cn: "": "";
					}
					id = rowid;
					rowid = tpidPrefix + rowid;
					if (ni) {
						prp = t.formatCol (0,1,'', null, rowid, true);
						row [row.length] = "<td role=\"gridcell\" class=\"ui-state-default jqgrid-rownum\" "+prp+"> 0 </ td>";
					}
					if (gi) {
						v = "<input role=\"checkbox\" type=\"checkbox\""+" id=\"jqg_"+tpid+"_"+rowid+"\" class=\"cbox\"/>";
						prp = t.formatCol (ni, 1,'', null, rowid, true);
						row [row.length] = "<td role=\"gridcell\" "+prp+">" + v + "</ td>";
					}
					se (si) {
						. linha [row.length] = $ (t) jqGrid ("addSubGridCell", gi + ni, 1);
					}
					for (i = gi + si + ni; i <tpcolModel.length; i + +) {
						cm = tpcolModel [i];
						nm = cm.name;
						lcdata [nm] = dados [nm];
						v = t.formatter (. rowid, $ jgrid.getAccessor (dados, nm), eu, de dados);
						prp = t.formatCol (i, 1, v, dados, idlinha, lcdata);
						row [row.length] = "<td role=\"gridcell\" "+prp+">" + v + "</ td>";
					}
					row.unshift (t.constructTr (rowid, falsa, possa, lcdata, dados, false));
					row [row.length] = "</ tr>";
					if (t.rows.length === 0) {
						$. ("Tabela: em primeiro lugar", t.grid.bDiv) append (row.join (''));
					} Else {
						switch (pos) {
							case 'última':
								$ (T.rows [t.rows.length-1]) depois (row.join ('')).;
								sind = t.rows.length-1;
								break;
							caso 'primeiro':
								. $ (T.rows [0]) depois (row.join (''));
								sind = 1;
								break;
							caso "depois":
								sind = $ (t) jqGrid ('getGridRowById', src).;
								if (sind) {
									if ($ (t.rows [sind.rowIndex +1]) hasClass ("ui-subgrid").) {$ (t.rows [sind.rowIndex +1]) após (linha);.}
									else {$ (sind) depois (row.join (''));.}
									sind = sind.rowIndex + 1;
								}	
								break;
							caso "antes":
								sind = $ (t) jqGrid ('getGridRowById', src).;
								if (sind) {
									. $ (Sind) antes (row.join (''));
									sind = sind.rowIndex - 1;
								}
								break;
						}
					}
					if (tpsubGrid === true) {
						. $ (T) jqGrid ("addSubGrid", gi + ni, sind);
					}
					tprecords + +;
					tpreccount + +;
					. $ (T) triggerHandler ("jqGridAfterInsertRow" [rowid, dados, dados]);
					if (ar) {tpafterInsertRow.call (t, rowid, dados, data);}
					k + +;
					if (tpdatatype === 'local') {
						lcdata [tplocalReader.id] = id;
						tp_index [id] = tpdata.length;
						tpdata.push (lcdata);
						lcdata = {};
					}
				}
				if (tpaltRows === verdadeiro &&! aradd) {
					if (pos === "último") {
						if ((t.rows.length-1)% 2 === 1) {$ (t.rows [t.rows.length-1]) addClass (CN),.}
					} Else {
						$ (T.rows). Cada (function (i) {
							if (i% 2 === 1) {$ (this) addClass (cn);.}
							else {$ (this) removeClass (cn);.}
						});
					}
				}
				t.updatepager (true, true);
				sucesso = true;
			});
		}
		retornar com êxito;
	},
	footerData: function (ação, dados, formato) {
		var nm, o sucesso = false, res = {}, title;
		função isEmpty (obj) {
			var i;
			for (i in obj) {
				if (obj.hasOwnProperty (i)) {return false;}
			}
			return true;
		}
		if (ação === indefinido) {action = "GET";}
		Se {format = true;} (typeof formato == "boolean"!)
		action = action.toLowerCase ();
		this.each (function () {
			var t = isso, vl;
			(! t.grid | | tpfooterrow) se {return false;}
			if (ação === "set") {if (isEmpty (dados)) {return false;}}
			sucesso = true;
			$ (This.p.colModel). Cada (function (i) {
				nm = this.name;
				if (ação === "set") {
					if (dados [nm]! == undefined) {
						vl = formato? t.formatter ("", dados [nm], i, dados, "editar"): dados [nm];
						title = this.title? {. "Title": $ jgrid.stripHtml (vl)}: {};
						.. $ ("Tr.footrow td: eq (" + i + ")", t.grid.sDiv) html (vl) attr (título);
						sucesso = true;
					}
				} Else if (ação === "get") {
					. res [nm] = $ ("tr.footrow td: eq (" + i + ")", t.grid.sDiv) html ();
				}
			});
		});
		voltar acção === "pegar"? res: o sucesso;
	},
	showHideCol: function (colname, show) {
		voltar this.each (function () {
			var $ t = isso, fndh = false, brd = $. jgrid.cell_width? 0: $ tpcellLayout, cw;
			if ($ t.grid!) {return;}
			if (typeof colname === 'string') {colname = [colname];}
			show = show! == "none"? "": "None";
			var sw = mostrar === ""? verdadeiro: false,
			gh = $ tpgroupHeader && (typeof $ tpgroupHeader === 'objeto' | | $ isFunction ($ tpgroupHeader).);
			if (gh) {$ ($ t) jqGrid ('destroyGroupHeader', false);.}
			$ (This.p.colModel). Cada (function (i) {
				if ($. inArray (this.name, colname)! == -1 && this.hidden === sw) {
					if ($ tpfrozenColumns === verdadeiro this.frozen && === true) {
						return true;
					}
					$ ("Tr [role = RowHeader]", $ t.grid.hDiv). Cada (function () {
						. $ (This.cells [i]) css ("display", show);
					});
					$ ($ T.rows). Cada (function () {
						if (! $ (this). hasClass ("jqgroup")) {
							. $ (This.cells [i]) css ("display", show);
						}
					});
					if ($ tpfooterrow) {$. ("tr.footrow td: eq (" + i + ")", $ t.grid.sDiv) css ("display", show);}
					cw = parseInt (this.width, 10);
					if (espetáculo === "none") {
						$ Tptblwidth - = + brd cw;
					} Else {
						$ Tptblwidth + = + brd cw;
					}
					! this.hidden = sw;
					fndh = true;
					. $ ($ T) triggerHandler ("jqGridShowHideCol", [sw, this.name, i]);
				}
			});
			if (fndh === true) {
				if ($ tpshrinkToFit === verdadeiro && isNaN ($ tpheight)!) {$ tptblwidth + = parselnt ($ tpscrollOffset, 10);}
				. $ ($ T) jqGrid ("setGridWidth", $ tpshrinkToFit === true $ tptblwidth:? $ Tpwidth);
			}
			if (GH) {
				$ ($ T) jqGrid ('setGroupHeaders', $ tpgroupHeader).;
			}
		});
	},
	hideCol: function (colname) {
		voltar this.each (function () {$ (this) jqGrid ("showHideCol", colname, "none");.});
	},
	showCol: function (colname) {
		voltar this.each (function () {$ (this) jqGrid ("showHideCol", colname, "");.});
	},
	remapColumns: function (permutação, UpdateCells, keepHeader)
	{
		função resortArray (a) {
			var ac;
			if (a.length) {
				. ac = $ MakeArray (a);
			} Else {
				. ac = $ estender ({}, a);
			}
			$. Cada (permutação, function (i) {
				a [i] = ac [este];
			});
		}
		var ts = this.get (0);
		resortRows de função (pai, clobj) {
			$. ("> Tr" + (clobj | | ""), pai) each (function () {
				var row = this;
				. var elems = $ MakeArray (row.cells);
				$. Cada (permutação, function () {
					var e = elems [este];
					se (e) {
						row.appendChild (e);
					}
				});
			});
		}
		resortArray (ts.p.colModel);
		resortArray (ts.p.colNames);
		resortArray (ts.grid.headers);
		resortRows ($ ("thead: em primeiro lugar", ts.grid.hDiv), keepHeader && ":. não (ui-jqgrid rótulos)");
		if (UpdateCells) {
			resortRows ($ ("#" + $ jgrid.jqID (ts.p.id) + "tbody: em primeiro lugar".) ". jqgfirstrow, tr.jqgrow, tr.jqfoot");
		}
		if (ts.p.footerrow) {
			resortRows ($ ("tbody: em primeiro lugar", ts.grid.sDiv));
		}
		if (ts.p.remapColumns) {
			if (ts.p.remapColumns.length!) {
				ts.p.remapColumns = $ MakeArray (permutação).;
			} Else {
				resortArray (ts.p.remapColumns);
			}
		}
		ts.p.lastsort = $ inArray (ts.p.lastsort, permuta).;
		if (ts.p.treeGrid) {ts.p.expColInd = $ inArray (ts.p.expColInd, permutação);.}
		. $ (Ts) triggerHandler ("jqGridRemapColumns", [permutação, UpdateCells, keepHeader]);
	},
	setGridWidth: function (nWidth, encolher) {
		voltar this.each (function () {
			Se {return;} (this.grid!)
			var $ t = isso, cw,
			initwidth = 0, brd = $. jgrid.cell_width? 0: $ tpcellLayout, LVC, vc = 0, hs = false, scw = $ tpscrollOffset, aw, gw = 0, cr;
			if (typeof encolher! == 'boolean') {
				encolher = $ tpshrinkToFit;
			}
			if (isNaN (nWidth)) {return;}
			nWidth = parseInt (nWidth, 10); 
			$ T.grid.width = $ tpwidth = nWidth;
			. $ (". # Gbox_" + $ jgrid.jqID ($ TPID)) css ("width", nWidth + "px");
			. $ (". # Gview_" + $ jgrid.jqID ($ TPID)) css ("width", nWidth + "px");
			. $ ($ T.grid.bDiv) css ("width", nWidth + "px");
			. $ ($ T.grid.hDiv) css ("width", nWidth + "px");
			if ($ tppager) {$ ($ tppager) css ("width", nWidth + "px");.}
			if ($ tptoppager) {$ ($ tptoppager) css ("width", nWidth + "px");.}
			if ($ tptoolbar [0] === true) {
				. $ ($ T.grid.uDiv) css ("width", nWidth + "px");
				if ($ tptoolbar [1] === "ambos") {$ ($ t.grid.ubDiv) css ("width", nWidth + "px");.}
			}
			if ($ tpfooterrow) {$ ($ t.grid.sDiv) css ("width", nWidth + "px");.}
			if (encolher === false && $ tpforceFit === true) {$ tpforceFit = false;}
			if (encolher === true) {
				$. Cada ($ tpcolModel, function () {
					if (this.hidden === false) {
						cw = this.widthOrg;
						initwidth + = + brd cw;
						if (this.fixed) {
							gw + = + brd cw;
						} Else {
							vc + +;
						}
					}
				});
				if (vc === 0) {return;}
				$ Tptblwidth = initwidth;
				aw = nWidth-brd * vc-gw;
				if (! isNaN ($ tpheight)) {
					if ($ ($ t.grid.bDiv) [0] clientHeight <$ ($ t.grid.bDiv) [0] scrollHeight |.. | $ t.rows.length === 1) {
						hs = true;
						aw - = ACS;
					}
				}
				initwidth = 0;
				var cle = $ t.grid.cols.length> 0;
				$. Cada ($ tpcolModel, function (i) {
					if (this.hidden === false &&! this.fixed) {
						cw = this.widthOrg;
						cw = Math.round (aw * cw / (* $ tptblwidth-brd vc-gw));
						if (cw <0) {return;}
						this.width = cw;
						initwidth + = cw;
						. $ t.grid.headers [i] width = cw;
						. $ t.grid.headers [i] el.style.width = cw + "px";
						if ($ tpfooterrow) {$ t.grid.footers [i] style.width = cw + "px";.}
						if (CLE) {. $ t.grid.cols [i] style.width = cw + "px";}
						lvc = i;
					}
				});

				Se {return;} (LVC!)

				cr = 0;
				if (hs) {
					if (nWidth-gw-(initwidth + * brd vc)! == ACS) {
						cr = nWidth-gw-(initwidth + brd * vc)-ACS;
					}
				} Else if (Math.abs (nWidth-gw-(initwidth + brd * vc))! == 1) {
					cr = nWidth-gw-(initwidth + brd * vc);
				}
				. $ TpcolModel [LVC] largura + = cr;
				$ Tptblwidth = initwidth + cr + brd * vc + gw;
				if ($ tptblwidth> nWidth) {
					var delta = $ tptblwidth - parselnt (nWidth, 10);
					$ Tptblwidth = nWidth;
					.. cw = $ tpcolModel [LVC] width = $ tpcolModel [LVC] largura-delta;
				} Else {
					. cw = $ tpcolModel [LVC] largura;
				}
				$ t.grid.headers [LVC] width = cw.;
				. $ t.grid.headers [LVC] el.style.width = cw + "px";
				if (CLE) {$ t.grid.cols [LVC] style.width = cw + "px";.}
				if ($ tpfooterrow) {
					. $ t.grid.footers [LVC] style.width = cw + "px";
				}
			}
			if ($ tptblwidth) {
				. $ ('Table: first', $ t.grid.bDiv) css ("largura", $ tptblwidth + "px");
				. $ ('Table: first', $ t.grid.hDiv) css ("largura", $ tptblwidth + "px");
				T.grid.hDiv.scrollLeft $ = $ t.grid.bDiv.scrollLeft;
				if ($ tpfooterrow) {
					. $ ('Table: first', $ t.grid.sDiv) css ("largura", $ tptblwidth + "px");
				}
			}
		});
	},
	setGridHeight: function (nh) {
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid!) {return;}
			var bDiv = $ ($ t.grid.bDiv);
			bDiv.css ({height: nh + (isNaN (nh) "": "px")});
			if ($ tpfrozenColumns === true) {
				/ / Siga a altura conjunto original de usar 16, melhor detecção de largura da barra de rolagem
				.. $ (. '#' + $ Jgrid.jqID ($ TPID) + "_FROZEN") pai () altura (bDiv.height () - 16);
			}
			$ Tpheight = NH;
			if ($ tpscroll) {$ t.grid.populateVisible ();}
		});
	},
	SetCaption: function (Newcap) {
		voltar this.each (function () {
			this.p.caption = Newcap;
			. $ ("Span.ui-jqgrid-título, span.ui-jqgrid-título-rtl", this.grid.cDiv) html (Newcap);
			. $ (This.grid.cDiv) show ();
		});
	},
	setLabel: function (colname, nData, prop, attrp) {
		voltar this.each (function () {
			var $ t = isso, pos = -1;
			if ($ t.grid!) {return;}
			if (colname! == indefinido) {
				$ ($ TpcolModel). Cada (function (i) {
					if (this.name colname ===) {
						pos = i; return false;
					}
				});
			} Else {return;}
			if (pos> = 0) {
				var thecol = $ ("tr.ui-jqgrid rótulos th: eq (" + pos + ")", $ t.grid.hDiv);
				if (nData) {
					var ico = $ (". s-ico", thecol);
					... $ ("[Id ^ = jqgh_]", thecol) empty () html (nData) append (ico);
					$ TpcolNames [pos] = nData;
				}
				if (prop) {
					if (typeof prop === 'string') {$ (thecol) addClass (prop);.} else {. $ (thecol) css (prop);}
				}
				if (typeof attrp === 'objeto') {$ (thecol) attr (attrp);.}
			}
		});
	},
	setCell: function (rowid, colname, nData, CSSp, attrp, forceupd) {
		voltar this.each (function () {
			var $ t = isso, pos = -1, v, título;
			if ($ t.grid!) {return;}
			if (isNaN (colname)) {
				$ ($ TpcolModel). Cada (function (i) {
					if (this.name colname ===) {
						pos = i; return false;
					}
				});
			} Else {pos = parseInt (colname, 10);}
			if (pos> = 0) {
				var ind = $ ($ t) jqGrid ('getGridRowById ", rowid).; 
				if (ind) {
					var tcell = $ ("td: eq (" + pos + ")", ind);
					if (nData == "" | | forceupd === true) {
						v = $ t.formatter (rowid, nData, pos, ind, "editar");
						title = $ tpcolModel [pos]. título? {"Title": $ jgrid.stripHtml (v).}: {};
						if ($ tptreeGrid && $ (". árvore-wrap", $ (tcell)). comprimento> 0) {
							.. $ ("Span", $ (tcell)) html (v) attr (título);
						} Else {
							.. $ (Tcell) html (v) attr (título);
						}
						if ($ tpdatatype === "local") {
							var cm = $ tpcolModel [pos], índice;
							nData = cm.formatter && typeof cm.formatter === 'string' && cm.formatter === 'date'? . $ Unformat.date.call ($ t, nData, cm): nData;
							index = $ tp_index [. $ jgrid.stripPref ($ tpidPrefix, rowid)];
							if (index! == indefinido) {
								$ Tpdata [índice] [cm.name] = nData;
							}
						}
					}
					if (typeof CSSp === 'string') {
						. $ (Tcell) addClass (CSSp);
					} Else if (CSSp) {
						. $ (Tcell) css (CSSp);
					}
					if (typeof attrp === 'objeto') {$ (tcell) attr (attrp);.}
				}
			}
		});
	},
	GetCell: function (rowid, col) {
		var ret = false;
		this.each (function () {
			var $ t = isso, pos = -1;
			if ($ t.grid!) {return;}
			if (isNaN (col)) {
				$ ($ TpcolModel). Cada (function (i) {
					if (this.name col ===) {
						pos = i; return false;
					}
				});
			} Else {pos = parseInt (col, 10);}
			if (pos> = 0) {
				var ind = $ ($ t) jqGrid ('getGridRowById ", rowid).;
				if (ind) {
					try {
						. ret = $ unformat.call ($ t, $ ("td: eq (" + pos + ")", ind) {RowId: ind.id, colModel: $ tpcolModel [pos]}, pos);
					} Catch (e) {
						. ret = $ jgrid.htmlDecode ($ ("td: eq (". + pos + ")", ind) html ());
					}
				}
			}
		});
		voltar ret;
	},
	getCol: function (col, obj, mathopr) {
		var ret = [], val, soma = 0, min, max, v;
		obj = typeof obj! == 'boolean'? false: obj;
		if (mathopr === indefinido) {mathopr = false;}
		this.each (function () {
			var $ t = isso, pos = -1;
			if ($ t.grid!) {return;}
			if (isNaN (col)) {
				$ ($ TpcolModel). Cada (function (i) {
					if (this.name col ===) {
						pos = i; return false;
					}
				});
			} Else {pos = parseInt (col, 10);}
			if (pos> = 0) {
				var ln = $ t.rows.length, i = 0, dlen = 0;
				if (ln && ln> 0) {
					while (i <ln) {
						if ($ ($ t.rows [i]). hasClass ('jqgrow')) {
							try {
								val = $ unformat.call ($ t, $ ($ t.rows [i] células [pos]). {. RowId:. $ t.rows [i] id, colModel: $ tpcolModel [pos]}, pos );
							} Catch (e) {
								. val = $ jgrid.htmlDecode (.. $ t.rows [i] células [pos] innerHTML);
							}
							if (mathopr) {
								v = parseFloat (val);
								if (isNaN! (v)) {
									soma + = v;
									if (max === indefinido) {max = min = v;}
									min = Math.min (min, v);
									max = Math.max (max, v);
									dlen + +;
								}
							}
							else if (obj) {ret.push ({id: $ t.rows [i] id, valor:. val});}
							else {ret.push (val);}
						}
						i + +;
					}
					if (mathopr) {
						switch (mathopr.toLowerCase ()) {
							case 'soma': ret = soma; break;
							case 'média': ret = soma / dlen; break;
							case 'count': ret = (ln-1); break;
							caso 'min': ret = min; break;
							caso 'max': ret = max; break;
						}
					}
				}
			}
		});
		voltar ret;
	},
	clearGridData: function (clearfooter) {
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid!) {return;}
			if (typeof clearfooter == 'boolean'!) {clearfooter = false;}
			if ($ tpdeepempty) {. $ (. "#" + $ jgrid.jqID ($ TPID) + "tbody: primeiro tr: gt (0)") remove ();}
			else {
				var trf = $ ("#" + $ jgrid.jqID ($ TPID) + "tbody: primeiro tr: em primeiro lugar".) [0];
				.. $ (. "#" + $ Jgrid.jqID ($ TPID) + "tbody: primeiro") empty () anexa (TRF);
			}
			if ($ tpfooterrow && clearfooter) {$ ("ui-jqgrid-ftable td.", $ t.grid.sDiv) html ("");.}
			$ Tpselrow = null; $ tpselarrrow = []; $ tpsavedRow = [];
			$ Tprecords = 0; $ tppage = 1; $ tplastpage = 0; tpreccount $ = 0;
			$ Tpdata = []; $ tp_index = {};
			$ T.updatepager (true, false);
		});
	},
	getInd: function (rowid, rc) {
		var ret = false, rw;
		this.each (function () {
			rw = $ (this) jqGrid ('getGridRowById ", rowid).;
			if (rw) {
				ret = rc === verdade? rw: rw.rowIndex;
			}
		});
		voltar ret;
	},
	bindKeys: function () {definições
		var o = $. estender ({
			onEnter: null,
			onSpace: null,
			onLeftKey: null,
			onRightKey: null,
			scrollingRows: true
		}, Configurações | | {});
		voltar this.each (function () {
			var $ t = this;
			if (!. $ ('body') é ('[papel]')) {$ ('body') attr ('papel', 'aplicação');.}
			$ Tpscrollrows = o.scrollingRows;
			$ ($ T). Keydown (function (event) {
				var target = $ ($ t). find ('tr [tabindex = 0]') [0], id, r, mente,
				expandida = $ tptreeReader.expanded_field;
				/ / Verificação para as teclas de seta
				if (target) {
					mente = $ tp_index [$ jgrid.stripPref ($ tpidPrefix, target.id).];
					if (event.keyCode === 37 | | event.keyCode === 38 | | event.keyCode === 39 | | event.keyCode === 40) {
						Key / / para cima
						if (event.keyCode === 38) {
							r = target.previousSibling;
							id = "";
							if (r) {
								if ($ (r) é (. ": hidden")) {
									enquanto (r) {
										r = r.previousSibling;
										if (!. $ (r) é (": hidden".) && $ (r) hasClass ('jqgrow')) {id = r.id; break;}
									}
								} Else {
									id = r.id;
								}
							}
							$ ($ T) jqGrid ('setSelection', id, é verdade, do evento).;
							event.preventDefault ();
						}
						/ / Se a chave é a seta para baixo
						if (=== event.keyCode 40) {
							r = target.nextSibling;
							id = "";
							if (r) {
								if ($ (r) é (. ": hidden")) {
									enquanto (r) {
										r = r.nextSibling;
										if (!. $ (r) é (": hidden".) && $ (r) hasClass ('jqgrow')) {id = r.id; break;}
									}
								} Else {
									id = r.id;
								}
							}
							$ ($ T) jqGrid ('setSelection', id, é verdade, do evento).;
							event.preventDefault ();
						}
						/ / Para a esquerda
						if (event.keyCode === 37) {
							if ($ tptreeGrid && $ tpdata [mente] [expandida]) {
								.. $ (Target) find ("div.treeclick") trigger ('click');
							}
							. $ ($ T) triggerHandler ("jqGridKeyLeft", [$ tpselrow]);
							if ($. isFunction (o.onLeftKey)) {
								o.onLeftKey.call ($ t, $ tpselrow);
							}
						}
						/ / Direita
						if (event.keyCode === 39) {
							if ($ tptreeGrid &&! $ tpdata [mente] [expandida]) {
								.. $ (Target) find ("div.treeclick") trigger ('click');
							}
							. $ ($ T) triggerHandler ("jqGridKeyRight", [$ tpselrow]);
							if ($. isFunction (o.onRightKey)) {
								o.onRightKey.call ($ t, $ tpselrow);
							}
						}
					}
					/ / Verifica se foi pressionado entrar em uma grade ou TreeGrid nó
					else if (=== event.keyCode 13) {
						. $ ($ T) triggerHandler ("jqGridKeyEnter", [$ tpselrow]);
						if ($. isFunction (o.onEnter)) {
							o.onEnter.call ($ t, $ tpselrow);
						}
					} Else if (event.keyCode === 32) {
						. $ ($ T) triggerHandler ("jqGridKeySpace", [$ tpselrow]);
						if ($. isFunction (o.onSpace)) {
							o.onSpace.call ($ t, $ tpselrow);
						}
					}
				}
			});
		});
	},
	unbindKeys: function () {
		voltar this.each (function () {
			. $ (This) desvincular ('Keydown');
		});
	},
	getLocalRow: function (rowid) {
		var ret = false, ind;
		this.each (function () {
			if (rowid! == undefined) {
				[. $ jgrid.stripPref (this.p.idPrefix, rowid)] ind = this.p._index;
				if (ind> = 0) {
					ret = this.p.data [ind];
				}
			}
		});
		voltar ret;
	}
});
}) (JQuery);
/ * Jshint eqeqeq: false * /
/ * JQuery globais * /
(Function ($) {
/ **
 * JqGrid extensão para métodos personalizados
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/ 
 * 
 * Wildraid wildraid@mail.ru
 * Oleg Kiriljuk oleg.kiriljuk @ ok-soft-gmbh.com
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
** /
"Use strict";
$. Jgrid.extend ( {
	getColProp: function (colname) {
		var ret = {}, $ t = this [0];
		if (! $ t.grid) {return false;}
		var cm = $ tpcolModel, i;
		for (i = 0; i <cM.length; i + +) {
			if (cM [i]. === colname nome) {
				ret = cM [i];
				break;
			}
		}
		voltar ret;
	},
	setColProp: function (colname, obj) {
		/ / Não definir a largura não irá funcionar
		voltar this.each (function () {
			if (this.grid) {
				if (obj) {
					var cm = this.p.colModel, i;
					for (i = 0; i <cM.length; i + +) {
						if (cM [i]. === colname nome) {
							. $ Estender (true, this.p.colModel [i], obj);
							break;
						}
					}
				}
			}
		});
	},
	sortGrid: function (colname, recarregar sor) {
		voltar this.each (function () {
			var $ t = isso, idx = -1, i, sobj = false;
			if ($ t.grid!) {return;}
			if (colname!) {colname = $ tpsortname;}
			for (i = 0; i <$ tpcolModel.length; i + +) {
				if ($ tpcolModel [i] índice === colname |. |. $ tpcolModel [i] Nome === colname) {
					idx = i;
					if ($ tpfrozenColumns === verdadeiro && $ tpcolModel [i]. === congelado true) {
						sobj = $ t.grid.fhDiv.find ("#" + $ TPID + "_" + colname);
					}
					break;
				}
			}
			if (idx! == -1) {
				var tipo = $ tpcolModel [idx] classificáveis.;
				if (typeof tipo == 'boolean'!) {sort = true;}
				if (typeof recarregar == 'boolean'!) {recarga = false;}
				if (tipo) {$ t.sortData ("jqgh_" + $ TPID + "_" + colname, idx, recarregar, sor, sobj);}
			}
		});
	},
	clearBeforeUnload: function () {
		voltar this.each (function () {
			var grade = this.grid;
			grid.emptyRows.call (isso, verdade, verdade) / / este trabalho rápido o suficiente e reduzir o tamanho dos vazamentos de memória, se tivermos alguém

			. $ (Document) desvincular ("mouseup.jqGrid" + this.p.id); 
			. $ (Grid.hDiv) desvincular ("mousemove"); / / TODO add namespace
			. $ (This) desvincular ();

			grid.dragEnd = null;
			grid.dragMove = null;
			grid.dragStart = null;
			grid.emptyRows = null;
			grid.populate = null;
			grid.populateVisible = null;
			grid.scrollGrid = null;
			grid.selectionPreserver = null;

			grid.bDiv = null;
			grid.cDiv = null;
			grid.hDiv = null;
			grid.cols = null;
			var i, l = grid.headers.length;
			for (i = 0; i <l; i + +) {
				grid.headers [i] el = nulos.;
			}

			this.formatCol = null;
			this.sortData = null;
			this.updatepager = null;
			this.refreshIndex = null;
			this.setHeadCheckBox = null;
			this.constructTr = null;
			this.formatter = null;
			this.addXmlData = null;
			this.addJSONData = null;
		});
	},
	GridDestroy: function () {
		voltar this.each (function () {
			if (this.grid) { 
				if (this.p.pager) {/ / se não fizer parte da rede
					$ (This.p.pager) remove ().;
				}
				try {
					. $ (This) jqGrid ('clearBeforeUnload');
					. $ (". # Gbox_" + $ jgrid.jqID (this.id)) remove ();
				} Catch (_) {}
			}
		});
	},
	GridUnload: function () {
		voltar this.each (function () {
			Se {return;} (this.grid!)
			var defgrid = {. id: $ (this) attr ('id'), cl: $ (this) attr ('class').};
			if (this.p.pager) {
				. $ (This.p.pager) empty () removeClass ("ui-state-default ui-jqgrid-pager-bottom canto").;
			}
			var newtable = document.createElement ('tabela');
			. $ (Newtable) attr ({id: defgrid.id});
			newtable.className = defgrid.cl;
			. var gid = $ jgrid.jqID (this.id);
			$ (Newtable) removeClass ("ui-jqgrid-btable").;
			if ($ (this.p.pager). pais ("# gbox_" + GID). comprimento === 1) {
				.. $ (Newtable) insertBefore ("# gbox_" + gid) show ();
				$ (This.p.pager) insertBefore ("# gbox_" + gid).;
			} Else {
				.. $ (Newtable) insertBefore ("# gbox_" + gid) show ();
			}
			. $ (This) jqGrid ('clearBeforeUnload');
			$ ("# Gbox_" + gid) remove ().;
		});
	},
	setGridState: function (estado) {
		voltar this.each (function () {
			Se {return;} (this.grid!)
			var $ t = this;
			if (estado === 'escondido') {
				. $ ("... Ui-jqgrid-bdiv, ui-jqgrid-hdiv", "# gview_" + $ jgrid.jqID ($ TPID)) slideUp ("rápido");
				if ($ tppager) {$ ($ tppager) slideUp ("rápido");.}
				if ($ tptoppager) {$ ($ tptoppager) slideUp ("rápido");.}
				if ($ tptoolbar [0] === true) {
					if ($ tptoolbar [1] === 'tanto') {
						. $ ($ T.grid.ubDiv) slideUp ("rápido");
					}
					. $ ($ T.grid.uDiv) slideUp ("rápido");
				}
				if ($ tpfooterrow) {$ slideUp ("rápido") ("ui-jqgrid-sdiv.", "# gbox_" + $ jgrid.jqID ($ TPID).);.}
				$ (". Ui-jqgrid-titlebar-próximo período", $ t.grid.cDiv). RemoveClass ("ui-icon-círculo-triângulo-n"). AddClass ("ui-icon-círculo-triângulo-s" );
				$ Tpgridstate = 'escondido';
			} Else if (estado === 'visível') {
				. $ ("... Ui-jqgrid-hdiv, ui-jqgrid-bdiv", "# gview_" + $ jgrid.jqID ($ TPID)) slideDown ("rápido");
				if ($ tppager) {$ ($ tppager) slideDown ("rápido");.}
				if ($ tptoppager) {$ ($ tptoppager) slideDown ("rápido");.}
				if ($ tptoolbar [0] === true) {
					if ($ tptoolbar [1] === 'tanto') {
						. $ ($ T.grid.ubDiv) slideDown ("rápido");
					}
					. $ ($ T.grid.uDiv) slideDown ("rápido");
				}
				if ($ tpfooterrow) {$ slideDown ("rápido") ("ui-jqgrid-sdiv.", "# gbox_" + $ jgrid.jqID ($ TPID).);.}
				$ (". Ui-jqgrid-titlebar-próximo período", $ t.grid.cDiv). RemoveClass ("ui-icon-círculo-triângulo-s"). AddClass ("ui-icon-círculo-triângulo-n" );
				$ Tpgridstate = 'visível';
			}

		});
	},
	filterToolbar: function (p) {
		p = $. estender ({
			autosearch: true,
			searchOnEnter: true,
			beforeSearch: null,
			afterSearch: null,
			beforeClear: null,
			afterClear: null,
			searchurl:'',
			stringResult: false,
			groupOp: 'E',
			defaultSearch: "bw",
			searchOperators: false,
			operandTitle ". Clique para selecionar operação de busca",
			operandos: {"eq": "==", "ne":"!","lt":"<","le":"<=","gt":">","ge":">=","bw":"^","bn":"!^","in":"=","ni":"!=","ew":"|","en":"!@","cn":"~","nc":"!~","nu":"#","nn":"!#"}
		}, $ Jgrid.search, p | | {}).;
		voltar this.each (function () {
			var $ t = this;
			if (this.ftoolbar) {return;}
			var triggerToolbar = function () {
				var sdata = {}, j = 0, v, nm, sopt = {}, então;
				$. Cada ($ tpcolModel, function () {
					. var $ elem = $ ("# gs_" + $ jgrid.jqID (this.name), (this.frozen === verdadeiro && $ tpfrozenColumns === true) $ t.grid.fhDiv:? $ t.grid . hDiv);
					nm = this.index | | this.name;
					if () {p.searchOperators
						... assim = $ elem.parent () prev () crianças ("a") attr ("soper") | | p.defaultSearch;
					} Else {
						so = (this.searchoptions && this.searchoptions.sopt)? this.searchoptions.sopt [0]: this.stype === 'selecionar'? 'Eq': p.defaultSearch;
					}
					v = this.stype === "custom" && $. isFunction (this.searchoptions.custom_value) && $ elem.length> 0 && $ elem [0]. nodeName.toUpperCase () === "SPAN"?
						this.searchoptions.custom_value.call ($ t, $ elem.children ("customelement:. primeiro"), "get"):
						Elem.val $ ();
					if (v | | === assim "nu" | | tão === "nn") {
						sdata [nm] = v;
						sopt [nm] = assim;
						j + +;
					} Else {
						try {
							excluir $ tppostData [nm];
						} Catch (z) {}
					}
				});
				var sd = j> 0? verdadeiro: false;
				if (p.stringResult === verdadeiro | | $ tpdatatype === "local") {
					var ruleGroup = "{\" groupOp \ ": \" "+ p.groupOp +" \ ", \" regras \ ": [";
					var gi = 0;
					$. Cada (sdata, function (i, n) {
						if (gi> 0) {ruleGroup + = ",";}
						ruleGroup + = "{\" campo \ ": \" "+ i +" \ "";
						ruleGroup + = "\" op \ ": \" "+ sopt [i] +" \ ",";
						n + = "";
						ruleGroup + = "\" data \ ": \". "+ n.replace (/ \ \ / g, '\ \ \ \') replace (/ \" / g, '\ \' ") +" \ " } ";
						gi + +;
					});
					ruleGroup + = "]}";
					. $ Estender ($ tppostData, {filtros: ruleGroup});
					$. Cada (['searchField', 'searchString', 'searchOper'], function (i, n) {
						if ($ tppostData.hasOwnProperty (n)) {$ excluir tppostData [n];}
					});
				} Else {
					. $ Estender ($ tppostData, sdata);
				}
				var saveurl;
				if ($ tpsearchurl) {
					saveurl = $ tpurl;
					$ ($ T) jqGrid ("setGridParam", {url: $ tpsearchurl}).;
				}
				var BSR = $ ($ t). triggerHandler ("jqGridToolbarBeforeSearch") === 'stop'? verdadeiro: false;
				Se {BSR = p.beforeSearch.call ($ t);} (BSR && $ isFunction (p.beforeSearch)!).
				se {$ ($ t) jqGrid ("setGridParam", {busca: sd}) gatilho ("reloadGrid", [{page: 1}])..;} (BSR!)
				if (saveurl) {$ ($ t) jqGrid ("setGridParam", {url: saveurl});.}
				. $ ($ T) triggerHandler ("jqGridToolbarAfterSearch");
				if ($ isFunction (p.afterSearch).) {p.afterSearch.call ($ t);}
			},
			clearToolbar = function (trigger) {
				var sdata = {}, j = 0, nm;
				trigger = (trigger typeof! == 'boolean')? verdadeiro: gatilho;
				$. Cada ($ tpcolModel, function () {
					. var v, $ elem = $ ("# gs_" + $ jgrid.jqID (this.name), (this.frozen === verdadeiro && $ tpfrozenColumns === true) $ t.grid.fhDiv: $ t . grid.hDiv);
					if (this.searchoptions && this.searchoptions.defaultValue == indefinido!) {v = this.searchoptions.defaultValue;}
					nm = this.index | | this.name;
					switch (this.stype) {
						caso 'selecionar':
							$ Elem.find ("Opção"). Cada (function (i) {
								if (i === 0) {this.selected = true;}
								if ($ this (). val () === v) {
									this.selected = true;
									return false;
								}
							});
							if (v! == indefinido) {
								/ / Colocar a chave e não o texto
								sdata [nm] = v;
								j + +;
							} Else {
								try {
									excluir $ tppostData [nm];
								} Catch (e) {}
							}
							break;
						caso 'text':
							$ Elem.val (v);
							if (v! == indefinido) {
								sdata [nm] = v;
								j + +;
							} Else {
								try {
									excluir $ tppostData [nm];
								} Catch (y) {}
							}
							break;
						caso 'custom':
							if ($. isFunction (this.searchoptions.custom_value) && $ elem.length> 0 && $ elem [0]. nodeName.toUpperCase () === "SPAN") {
								this.searchoptions.custom_value.call (". customelement: primeiro" $ t, $ elem.children (), "set", v);
							}
							break;
					}
				});
				var sd = j> 0? verdadeiro: false;
				if (p.stringResult === verdadeiro | | $ tpdatatype === "local") {
					var ruleGroup = "{\" groupOp \ ": \" "+ p.groupOp +" \ ", \" regras \ ": [";
					var gi = 0;
					$. Cada (sdata, function (i, n) {
						if (gi> 0) {ruleGroup + = ",";}
						ruleGroup + = "{\" campo \ ": \" "+ i +" \ "";
						ruleGroup + = "\" op \ ": \" "+" eq "+" \ "";
						n + = "";
						ruleGroup + = "\" data \ ": \". "+ n.replace (/ \ \ / g, '\ \ \ \') replace (/ \" / g, '\ \' ") +" \ " } ";
						gi + +;
					});
					ruleGroup + = "]}";
					. $ Estender ($ tppostData, {filtros: ruleGroup});
					$. Cada (['searchField', 'searchString', 'searchOper'], function (i, n) {
						if ($ tppostData.hasOwnProperty (n)) {$ excluir tppostData [n];}
					});
				} Else {
					. $ Estender ($ tppostData, sdata);
				}
				var saveurl;
				if ($ tpsearchurl) {
					saveurl = $ tpurl;
					$ ($ T) jqGrid ("setGridParam", {url: $ tpsearchurl}).;
				}
				var BCV = $ ($ t). triggerHandler ("jqGridToolbarBeforeClear") === 'stop'? verdadeiro: false;
				Se {BCV = p.beforeClear.call ($ t);} (BCV && $ isFunction (p.beforeClear)!).
				if (! BCV) {
					if (gatilho) {
						$ ($ T) jqGrid ("setGridParam", {busca: sd}) gatilho ("reloadGrid", [{page: 1}])..;
					}
				}
				if (saveurl) {$ ($ t) jqGrid ("setGridParam", {url: saveurl});.}
				. $ ($ T) triggerHandler ("jqGridToolbarAfterClear");
				Se {p.afterClear ();} ($ isFunction (p.afterClear).)
			},
			toggleToolbar = function () {
				var Trow = $ ("tr.ui-search-barra de ferramentas", $ t.grid.hDiv),
				trow2 = $ tpfrozenColumns === verdade? $ ("Tr.ui-search-barra de ferramentas", $ t.grid.fhDiv): false;
				if (trow.css ("display") === 'none') {
					trow.show (); 
					if (trow2) {
						trow2.show ();
					}
				} Else { 
					trow.hide (); 
					if (trow2) {
						trow2.hide ();
					}
				}
			},
			buildRuleMenu = function (elem, à esquerda, em cima) {
				. $ ("# Sopt_menu") remove ();

				esquerda = parseInt (esquerda, 10);
				top = parseInt (superior, 10) + 18;

				. var fs = $ ('. ui-jqgrid-view') css ('font-size') | | '11px ';
				var str = '<id ul = class "sopt_menu" = "ui-search menu" papel "menu" = tabindex = "0" style = "font-size:' + fs + '; esquerda:' + esquerda + 'px; top: '+ top + "px";>',
				selecionado = $ (elem). attr ("soper"), selclass,
				aoprs = [], ina;
				. var i = 0, nm = $ (elem) attr ("colname"), len = $ tpcolModel.length;
				while (i <len) {
					if ($ tpcolModel [i]. === nome nm) {
						break;
					}
					i + +;
				}
				var cm = $ tpcolModel [i], options = $ estender ({}, cm.searchoptions).;
				if (options.sopt!) {
					options.sopt = [];
					options.sopt [0] = cm.stype === 'selecionar'? 'Eq': p.defaultSearch;
				}
				. $ Cada (p.odata, function () {aoprs.push (this.oper);});
				for (i = 0; i <options.sopt.length; i + +) {
					ina = $ inArray (options.sopt [i], aoprs).;
					if (ina! == -1) {
						selclass = selecionado === p.odata [ina]. oper? "Ui-state-destaque": "";
						str + = '<li class="ui-menu-item'+selclass+'" role="presentation"> <a class = "ui-corner-all g-menu-item de" tabindex = "0" papel = "menuitem "value =" '+ p.odata [ina]. oper +' "oper =" "+ p.operands [p.odata [ina]. oper] +" "> <table cellspacing =" 0 "cellpadding =" 0 " border = "0"> <td width="25px"> '+ p.operands [p.odata [ina]. oper] +' </ td> <td> '+ p.odata [ina]. texto + '</ td> </ tr> </ table> </ a> </ li>';
					}
				}
				str + = "</ ul>";
				. $ ('Body') anexar (str);
				. $ ("# Sopt_menu") addClass ("ui ui-menu-widget ui-widget-conteúdo ui-corner-all");
				$ ("# Sopt_menu> li> a"). Pairar (
					function () {$ (this) addClass ("ui-state-foco");.}
					function () {$ (this) removeClass ("ui-state-foco");.}
				). Click (function (e) {
					var v = $ (this). attr ("value"),
					oper = $ (this) attr ("operar").;
					. $ ($ T) triggerHandler ("jqGridToolbarSelectOper" [v, oper, elem]);
					. $ ("# Sopt_menu") hide ();
					.. $ (Elem) texto (oper) attr ("soper", v);
					if (p.autosearch === true) {
						.. var inpelm = $ (elem) pai () next () crianças () [0].;
						if ($ (inpelm) val () |. | v === "nu" | | v === "nn") {
							triggerToolbar ();
						}
					}
				});
			};
			/ / Cria a linha
			var tr = $ ("<tr class='ui-search-toolbar' role='rowheader'> </ tr>");
			var timeoutHnd;
			$. Cada ($ tpcolModel, function (ci) {
				var cm = isso, soptions, surl, auto, selecione = "", sot = "=", por isso, eu,
				ª = $ ("<th role='columnheader' class='ui-state-default ui-th-column ui-th-"+$tpdirection+"'> </ th>"),
				THD = $ ("<div style='position:relative;height:100%;padding-right:0.3em;padding-left:0.3em;'> </ div>"),
				STBL = $ ("<table class='ui-search-table' cellspacing='0'> <td class='ui-search-oper'> </ td> <td class = 'ui-search- input '> </ td> <td class='ui-search-clear'> </ td> </ tr> </ table> ");
				if (this.hidden === true) {. $ (th) css ("display", "none");}
				this.search = this.search === false? false: true;
				if (this.stype === indefinido) {this.stype = 'text';}
				. soptions = $ estender ({}, this.searchoptions | | {});
				if (this.search) {
					if () {p.searchOperators
						so = (soptions.sopt)? soptions.sopt [0]: cm.stype === 'selecionar'? 'Eq': p.defaultSearch;
						for (i = 0; i <p.odata.length; i + +) {
							if (p.odata [i]. === oper-lo) {
								sot = p.operands [assim] | | "";
								break;
							}
						}
						var st = soptions.searchtitle! = null? soptions.searchtitle: p.operandTitle;
						selecionar = "<a title='"+st+"' style='padding-right: 0.5em;' soper='"+so+"' class='soptclass' colname='"+this.name+"'>" + sot + "</ a>";
					}
					.. $ ("Td: eq (0)", STBL) attr ("colIndex", ci) anexar (selecionar);
					if (soptions.clearSearch === indefinido) {
						soptions.clearSearch = true;
					}
					if (soptions.clearSearch) {
						$. ("Td: eq (2)", STBL) append ("<a title='Clear Pesquisa Value' style='padding-right: 0.3em;padding-left: 0.3em;' class='clearsearchclass'> x </ a> ");
					}
					switch (this.stype)
					{
					caso ", selecione":
						surl = this.surl | | soptions.dataUrl;
						if (surl) {
							/ / dados retornados já deveria ter construído html selecionar
							/ / Carrega jQuery primitivo
							auto = mil;
							$ (Auto) append (STBL).;
							$. Ajax ($. Estender ({
								url: surl,
								Tipo de dado: "html",
								sucesso: function (res) {
									if (soptions.buildSelect! == indefinido) {
										var d = soptions.buildSelect (res);
										se (d) {
											$ ("Td: eq (1)", STBL) anexar (d);.
										}
									} Else {
										$ ("Td: eq (1)", STBL) anexar (res);.
									}
									if (! == soptions.defaultValue indefinido) {$ ("select", self) val (soptions.defaultValue);.}
									. $ ("Select", self) attr ({name: cm.index | | cm.name, id: "gs_" + cm.name});
									if (soptions.attr) {$ ("select", self) attr (soptions.attr);.}
									. $ ("Select", self) css ({width: "100%"});
									/ / Preservar autoserch
									. $ Jgrid.bindEv.call ($ t, $ ("select", auto) [0], soptions);
									if (p.autosearch === true) {
										$ ("Select", self). Change (function () {
											triggerToolbar ();
											return false;
										});
									}
									res = null;
								}
							}, $ Jgrid.ajaxOptions, $ tpajaxSelectOptions | | {})).;
						} Else {
							var OSV, sep, delim;
							if () {cm.searchoptions
								OSV = cm.searchoptions.value === indefinido? "": Cm.searchoptions.value;
								setembro = cm.searchoptions.separator === indefinido? ":": Cm.searchoptions.separator;
								delim = cm.searchoptions.delimiter === indefinido? ";": Cm.searchoptions.delimiter;
							} Else if (cm.editoptions) {
								OSV = cm.editoptions.value === indefinido? "": Cm.editoptions.value;
								setembro = cm.editoptions.separator === indefinido? ":": Cm.editoptions.separator;
								delim = cm.editoptions.delimiter === indefinido? ";": Cm.editoptions.delimiter;
							}
							if (OSV) {	
								var elem = document.createElement ("select");
								elem.style.width = "100%";
								. $ (Elem) attr ({name: cm.index | | cm.name, id: "gs_" + cm.name});
								var sv, ov, chave, k;
								if (typeof OSV === "string") {
									so = oSv.split (delim);
									for (k = 0; k <so.length; k + +) {
										. sv = assim [k] split (setembro);
										ov = document.createElement ("opção");
										ov.value = sv [0]; ov.innerHTML = sv [1];
										elem.appendChild (ov);
									}
								} Else if (typeof OSV === "objeto") {
									for (chave na OSV) {
										if (oSv.hasOwnProperty (chave)) {
											ov = document.createElement ("opção");
											ov.value = chave; ov.innerHTML = OSV [key];
											elem.appendChild (ov);
										}
									}
								}
								if (soptions.defaultValue == indefinido!) {$ (elem) val (soptions.defaultValue);.}
								if (soptions.attr) {$ (elem) attr (soptions.attr);.}
								$ (Mil) append (STBL).;
								$ Jgrid.bindEv.call ($ t, elem, soptions).;
								$ ("Td: eq (1)", STBL) append (elem);.
								if (p.autosearch === true) {
									$ (Elem). Change (function () {
										triggerToolbar ();
										return false;
									});
								}
							}
						}
						break;
					caso "text":
						var df = soptions.defaultValue! == indefinido? soptions.defaultValue: "";

						. $ ("Td: eq (1)", STBL) anexar ("<input type = estilo 'text' = 'width: 100%; padding: 0px;" name =' "+ (cm.index | | cm. nome) + "'id =' gs_" + cm.name + "'value ='" + df + "'/>");
						$ (Mil) append (STBL).;

						if (soptions.attr) {$ ("input", mil) attr (soptions.attr);.}
						. $ Jgrid.bindEv.call ($ t, $ ("input", THD) [0], soptions);
						if (p.autosearch === true) {
							if (p.searchOnEnter) {
								$ ("Input", THD). Keypress (function (e) {
									chave var = e.charCode | | e.KeyCode | | 0;
									if (=== número 13) {
										triggerToolbar ();
										return false;
									}
									devolver este;
								});
							} Else {
								$ ("Input", THD). Keydown (function (e) {
									chave var = e.which;
									switch (key) {
										caso 13:
											return false;
										caso 9:
										caso 16:
										caso 37:
										Caso 38:
										case 39:
										caso 40:
										caso 27:
											break;
										default:
											if (timeoutHnd) {clearTimeout (timeoutHnd);}
											timeoutHnd = setTimeout (function () {triggerToolbar ();}, 500);
									}
								});
							}
						}
						break;
					caso "custom":
						$ ("Td: eq (1)", STBL) anexar ("<span style =" width: 95%; padding: 0px; "name = '" + (cm.index | | cm.name) + "'. ID = 'gs_ "+ cm.name +" "/>");
						$ (Mil) append (STBL).;
						try {
							if ($. isFunction (soptions.custom_element)) {
								var CELM = soptions.custom_element.call ($ t, soptions.defaultValue == indefinido soptions.defaultValue: "", soptions);
								if (CELM) {
									CELM = $ (CELM) addClass ("customelement").;
									.. $ (Mil) encontrar ("> extensão") append (CELM);
								} Else {
									jogar "e2";
								}
							} Else {
								jogar "e1";
							}
						} Catch (e) {
							if (e === "e1") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_element '"+ $. jgrid.edit.msg.nodefined, $. jgrid.edit.bClose) ;}
							if (e === "e2") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_element '"+ $. jgrid.edit.msg.novalue, $. jgrid.edit.bClose) ;}
							else {$ jgrid.info_dialog ($ jgrid.errors.errcap, typeof e === "string" e:.?. e.Message, $ jgrid.edit.bClose);.}
						}
						break;
					}
				}
				$ (Th) anexar (THD).;
				. $ (Tr) anexar (th);
				if (!) {p.searchOperators
					. $ ("Td: eq (0)", STBL) hide ();
				}
			});
			$ ("Thead mesa", $ t.grid.hDiv) anexar (TR).;
			if () {p.searchOperators
				$ (". Soptclass", tr). Click (function (e) {
					compensar var = $ (this). offset ()
					esquerda = (offset.left),
					top = (offset.top);
					buildRuleMenu (esta, à esquerda, em cima);
					e.stopPropagation ();
				});
				$ ("Body"). On ('click', function (e) {
					if (e.target.className! == "soptclass") {
						. $ ("# Sopt_menu") hide ();
					}
				});
			}
			$ (". Clearsearchclass", tr). Click (function (e) {
				var. ptr = $ (this), pais ("tr: em primeiro lugar"),
				coli = parseInt ($ ("td.ui-search-Oper", ptr). attr ('colIndex'), 10),
				. sval = $ estender ({}, $ tpcolModel [coli] searchOptions |. | {}),
				dval = sval.defaultValue? sval.defaultValue: "";
				if ($ tpcolModel [coli]. === stype "select") {
					if (dval) {
						$ ("Td.ui-search-selecção de entrada", ptr) val (dval).;
					} Else {
						$ ("Td.ui-search-selecção de entrada", ptr) [0] = 0 selectedIndex.;
					}
				} Else {
					. $ ("Input td.ui-search-input", ptr) val (dval);
				}
				Tipo / / TODO pesquisa personalizada
				if (p.autosearch === true) {
					triggerToolbar ();
				}

			});
			this.ftoolbar = true;
			this.triggerToolbar = triggerToolbar;
			this.clearToolbar = clearToolbar;
			this.toggleToolbar = toggleToolbar;
		});
	},
	destroyFilterToolbar: function () {
		voltar this.each (function () {
			if (! this.ftoolbar) {
				retorno;
			}
			this.triggerToolbar = null;
			this.clearToolbar = null;
			this.toggleToolbar = null;
			this.ftoolbar = false;
			. $ (This.grid.hDiv) encontrar ("table thead tr.ui-search-barra de ferramentas") remove ().;
		});
	},
	destroyGroupHeader: function (nullHeader)
	{
		if (nullHeader === indefinido) {
			nullHeader = true;
		}
		voltar this.each (function ()
		{
			var $ t = isso, $ tr, i, l, cabeçalhos $ mil, $ redimensionamento, grade = $ t.grid,
			thead = $ ("table.ui-jqgrid-htable thead", grid.hDiv), cm = $ tpcolModel, hc;
			Se {return;} (grade!)

			. $ (This) desvincular ('setGroupHeaders.');
			$ Tr = $ ("<tr>", {papel: "RowHeader"}). AddClass ("ui-jqgrid rótulos");
			headers = grid.headers;
			for (i = 0, l = headers.length; i <l; i + +) {
				hc = cm [i]. escondido? "None": "";
				$ Dia = $ (headers [i]. El)
					. Largura (headers [i]. Largura)
					. Css ('display', hc);
				try {
					$ Th.removeAttr ("rowSpan");
				} catch (rs) {
					/ / IE 6/7
					$ Th.attr ("rowSpan", 1);
				}
				$ Tr.append ($ mil);
				$ Redimensionamento = $ th.children ("span.ui-jqgrid-resize");
				if ($ resizing.length> 0) {/ / coluna redimensionável
					. $ Redimensionamento [0] style.height = "";
				}
				. $ Th.children ("div") [0] style.top = "";
			}
			.. $ (Thead) filhos ('tr.ui-jqgrid-etiquetas') remove ();
			. $ (Thead) preceder ($ tr);

			if (nullHeader === true) {
				. $ ($ T) jqGrid ('setGridParam', {'CabeçalhoDoGrupo ": null});
			}
		});
	},
	setGroupHeaders: function (o) {
		o = $. estender ({
			useColSpanStyle: false,
			groupHeaders: []
		}, O | | {});
		voltar this.each (function () {
			this.p.groupHeader = O;
			ts = var isso,
			i, cmi, pular = 0, $ tr, $ colHeader, th $ mil, thStyle,
			iCol,
			cghi,
			/ / StartColumnName,
			numberOfColumns,
			titleText,
			cVisibleColumns,
			colModel = ts.p.colModel,
			cml = colModel.length,
			ths = ts.grid.headers,
			$ Htable = $ ("table.ui-jqgrid-htable", ts.grid.hDiv),
			$ TrLabels = $ htable.children ("thead") crianças ("tr.ui-jqgrid rótulos: last").. AddClass ("JQG-segundo-fila-header"),
			Thead $ = $ htable.children ("thead"),
			$ TheadInTable,
			$ FirstHeaderRow = $ htable.find (". JQG-primeira-linha-header");
			if ($ firstHeaderRow [0] === indefinido) {
				$ FirstHeaderRow = $ ('<tr>', {papel: "fileira", "oculta-ária": "true"}) addClass ("JQG-primeira-linha-header") css ("altura", ".. auto ");
			} Else {
				FirstHeaderRow.empty $ ();
			}
			var $ firstRow,
			inColumnHeader = function (texto, ColumnHeaders) {
				comprimento var = columnHeaders.length, i;
				for (i = 0; i <comprimento, i + +) {
					if (ColumnHeaders [i]. startColumnName === texto) {
						voltar i;
					}
				}
				retornar -1;
			};

			. $ (Ts) preceder ($ thead);
			. $ Tr = $ ('<tr>', {papel: "RowHeader"}) addClass ("ui-jqgrid rótulos JQG terço-fila-header");
			for (i = 0; i <cml; i + +) {
				ª = ths [i] el.;
				$ Dia = $ (th);
				cmi = colModel [i];
				/ / Construir a próxima célula para a primeira linha do cabeçalho
				thStyle = {height: px '0 ', largura: ths [i] + largura.' px ', display: (cmi.hidden?' none ':'')};
				. $ ("<th>", {Papel: 'gridcell'}).. Css (thStyle) addClass ("ui-primeiro-th-" + ts.p.direction) appendTo ($ firstHeaderRow);

				th.style.width = "" / / remover estilo desnecessários
				iCol = inColumnHeader (cmi.name, o.groupHeaders);
				if (iCol> = 0) {
					cghi = o.groupHeaders [iCol];
					numberOfColumns = cghi.numberOfColumns;
					titleText = cghi.titleText;

					/ / Caclulate o número de colunas visíveis a partir dos próximos numberOfColumns colunas
					para (cVisibleColumns = 0, iCol = 0; iCol numberOfColumns <&& (i + iCol <cml); iCol + +) {
						if (! colModel [i + iCol]. oculto) {
							cVisibleColumns + +;
						}
					}

					/ / Os cabeçalhos próximos numberOfColumns serão movidas na próxima linha
					/ / Na linha atual será colocado o novo cabeçalho de coluna com o titleText.
					/ / O texto será sobre as colunas cVisibleColumns
					$ ColHeader = $ ('<th>') attr ({papel: "columnheader"}).
						. AddClass ("ui-ui-state default-th-coluna-header ui-th-" + ts.p.direction)
						. Css ({'height': '22px ',' border-top ': '0 px none'})
						. Html (titleText);
					if (cVisibleColumns> 0) {
						$ ColHeader.attr ("colspan", String (cVisibleColumns));
					}
					if () {ts.p.headertitles
						$ ColHeader.attr ("title", $ colHeader.text ());
					}
					/ / Esconder se não um cols visíveis
					if (cVisibleColumns === 0) {
						ColHeader.hide $ ();
					}

					$ Th.before ($ colHeader) / / inserir novo cabeçalho da coluna antes da atual
					$ Tr.append (th) / / mover o cabeçalho atual na próxima linha

					/ / Configura o coumter de cabeçalhos que irá ser movido na próxima linha
					skip = numberOfColumns - 1;
				} Else {
					if (pular === 0) {
						if (o.useColSpanStyle) {
							/ / Expandir a altura do cabeçalho de duas linhas
							$ Th.attr ("rowspan", "2");
						} Else {
							$ ('<th>', {Papel: "columnheader"})
								. AddClass ("ui-ui-state default-th-coluna-header ui-th-" + ts.p.direction)
								. Css ({"display": cmi.hidden 'none':'', 'border-top': '0 px none '})
								. InsertBefore ($ mil);
							$ Tr.append (th);
						}
					} Else {
						/ / Mover o cabeçalho para a próxima linha
						/ / $ Th.css ({"padding-top": "2px", altura: "19px"});
						$ Tr.append (th);
						pular -;
					}
				}
			}
			$ TheadInTable = $ (ts) filhos ("thead").;
			$ TheadInTable.prepend ($ firstHeaderRow);
			$ ($ Tr.insertAfter trLabels);
			$ Htable.append ($ theadInTable);

			if (o.useColSpanStyle) {
				/ / Aumenta a altura do redimensionamento espaço de cabeçalhos visíveis
				$ Htable.find ("span.ui-jqgrid-resize"). Cada (function () {
					var $ parent = $ (this) pai ().;
					if ($ parent.is (": visible")) {
						this.style.cssText = 'height:' + $ parent.height () + "px importante; cursor: col-redimensionamento»;
					}
				});

				/ / Definir posição do div classificável (o rótulo principal)
				/ / Com o texto do cabeçalho da coluna para o meio da célula.
				/ / Não se deve fazer isso para cabeçalhos escondidos.
				$ Htable.find ("div.ui-jqgrid-classificável"). Cada (function () {
					var $ ts = $ (this), $ parent = $ ts.parent ();
					if ($ parent.is (":") && visíveis $ parent.is (": tem (span.ui-jqgrid-redimensionamento)")) {
						$ Ts.css ('top', ($ parent.height () - $ ts.outerHeight ()) / 2 + 'px');
					}
				});
			}

			$ FirstRow = $ theadInTable.find ("tr.jqg-primeira-linha-header");
			$ (Ts). Bind ('jqGridResizeStop.setGroupHeaders', function (e, nw, idx) {
				. $ FirstRow.find ('th') eq (idx) largura (nw).;
			});
		});				
	},
	setFrozenColumns: function () {
		voltar this.each (function () {
			Se {return;} (this.grid!)
			var $ t = isso, cm = $ tpcolModel, i = 0, len = cm.length, maxfrozen = -1, congelado = false;
			/ / TODO TreeGrid e Suporte agrupamento
			if ($ tpsubGrid === verdadeiro | | $ tptreeGrid === verdadeiro | | $ tpcellEdit === verdadeiro | | $ tpsortable | | $ tpscroll | | $ tpgrouping)
			{
				retorno;
			}
			if ($ tprownumbers) {i + +;}
			if ($ tpmultiselect) {i + +;}
			
			/ / Obtém o índice máximo de col congelado
			while (i <len)
			{
				/ / Para a esquerda, nenhuma quebra congelado
				if (cm [i]. === congelado true)
				{
					congelado = true;
					maxfrozen = i;
				} Else {
					break;
				}
				i + +;
			}
			if (maxfrozen> = 0 && congelado) {
				var top = $ tpcaption? $ ($ T.grid.cDiv) outerHeight ():. 0,
				. hth = $ (". ui-jqgrid-htable.", "# gview_" + $ jgrid.jqID ($ TPID)) Altura ();
				/ / cabeçalhos
				if ($ tptoppager) {
					. top = topo + $ ($ t.grid.topDiv) outerHeight ();
				}
				if ($ tptoolbar [0] === true) {
					if ($ tptoolbar [1]! == "bottom") {
						. top = topo + $ ($ t.grid.uDiv) outerHeight ();
					}
				}
				$ T.grid.fhDiv = $ ('<div style = "position: absolute; esquerda: 0px; superior:' + top + 'px; height:' + hth + 'px;" class = "frozen-div ui-state- padrão ui-jqgrid-hdiv "> </ div> ');
				$ T.grid.fbDiv = $ ('<div style = "position: absolute; esquerda: 0px; superior:' + (parseInt (superior, 10) + parseInt (hth, 10) + 1) +" px; overflow- y: "class =" escondido frozen-bdiv ui-jqgrid-bdiv "> </ div> ');
				$ Append ($ t.grid.fhDiv) ("# gview_" + $ jgrid.jqID ($ TPID).).;
				. var htbl = $ (".. ui-jqgrid-htable", "# gview_" + $ jgrid.jqID ($ TPID)) clone (true);
				/ / Support CabeçalhoDoGrupo - somente se useColSpanstyle é falsa
				if ($ tpgroupHeader) {
					$ ("Tr.jqg-primeira-linha-header, tr.jqg terço-fila-header", htbl). Cada (function () {
						. $ ("Th: gt (" + maxfrozen + ")", this) remove ();
					});
					var swapfroz = -1, fdel = -1, cs, rs;
					$ ("Th tr.jqg-segundo-fila-header", htbl). Cada (function () {
						cs = parseInt (isto $ () attr ("colspan"), 10.);
						rs = parseInt (isto $ () attr ("rowspan"), 10.);
						if (rs) {
							swapfroz + +;
							fdel + +;
						}
						if (cs) {
							swapfroz = swapfroz + cs;
							fdel + +;
						}
						if (swapfroz === maxfrozen) {
							return false;
						}
					});
					if (swapfroz! == maxfrozen) {
						fdel = maxfrozen;
					}
					$ ("Tr.jqg-segundo-fila-header", htbl) cada (função. () {
						. $ ("Th: gt (" + fdel + ")", this) remove ();
					});
				} Else {
					$ ("Tr", htbl). Cada (function () {
						. $ ("Th: gt (" + maxfrozen + ")", this) remove ();
					});
				}
				. $ (Htbl) largura (1);
				/ / Stuff redimensionamento
				$ ($ T.grid.fhDiv). Anexar (htbl)
				. Mousemove (function (e) {
					if ($ t.grid.resizing) {$ t.grid.dragMove (e); return false;}
				});
				$ ($ T). Bind ('jqGridResizeStop.setFrozenColumns', function (E, W, index) {
					var RHTH = $ (". ui-jqgrid-htable", $ t.grid.fhDiv);
					$ ("Th: eq (" + index + ")", RHTH) largura (w);. 
					var btd = $ ("ui-jqgrid-btable.", $ t.grid.fbDiv);
					$. ("Tr: primeiro td: eq (" + index + ")", btd) largura (w); 
				});
				Stuff / / classificação
				$ ($ T). Bind ('jqGridSortCol.setFrozenColumns', function (e, índice idxcol) {

					var previousSelectedTh = $ ("tr.ui-jqgrid rótulos: última th: eq (" + $ tplastsort + ")", $ t.grid.fhDiv), newSelectedTh = $ ("tr.ui-jqgrid-etiquetas: último dia : eq ("+ idxcol +") ", $ t.grid.fhDiv);

					$ ("Span.ui-grid-ico-tipo", previousSelectedTh) addClass ('ui-state-deficientes ").;
					. $ (PreviousSelectedTh) attr ("selecionado aria-", "false");
					$ ("Span.ui-icon-" + $ tpsortorder, newSelectedTh) removeClass ('ui-state-deficientes ").;
					. $ (NewSelectedTh) attr ("selecionado aria-", "true");
					if (! tpviewsortcols $ [0]) {
						if ($ tplastsort! == idxcol) {
							$ ("Span.s-ico", previousSelectedTh) hide ().;
							$ ("Span.s-ico", newSelectedTh) show ().;
						}
					}
				});
				
				/ / Stuff dados
				/ / TODO apoio para setRowData
				$ Append ($ t.grid.fbDiv) ("# gview_" + $ jgrid.jqID ($ TPID).).;
				$ ($ T.grid.bDiv). Rolagem (function () {
					. $ ($ T.grid.fbDiv) scrollTop ($ (this) scrollTop ().);
				});
				if ($ tphoverrows === true) {
					$ ("#" + $ Jgrid.jqID ($ TPID).) Desvincular ('mouseover') desvincular ('mouseout')..;
				}
				$ ($ T). Bind ('jqGridAfterGridComplete.setFrozenColumns', function () {
					(. "#" + $ Jgrid.jqID ($ TPID) + "_FROZEN"). $ Remove ();
					. $ ($ T.grid.fbDiv) Altura (. $ ($ T.grid.bDiv) height () -16);
					. var btbl = $ (". #" + $ jgrid.jqID ($ TPID)) clone (true);
					$ ("Tr [role = linha]", btbl) cada (função. () {
						. $ ("Td [role = gridcell]: gt (" + maxfrozen + ")", this) remove ();
					});

					.. $ (Btbl) largura (1) attr ("id", $ TPID + "_FROZEN");
					$ ($ T.grid.fbDiv) append (btbl).;
					if ($ tphoverrows === true) {
						$ ("Tr.jqgrow", btbl). Pairar (
							function () {$ (this) addClass ("ui-state-foco");. $ ("#" + $ jgrid.jqID (this.id), "#" + $ jgrid.jqID ($ TPID).. ). addClass ("ui-state-pairar");},
							function () {$ (this) removeClass ("ui-state-foco");... $ ("#" + $ jgrid.jqID (this.id), "#" + $ jgrid.jqID ($ TPID) ) removeClass ("ui-state-foco");.}
						);
						$ ("Tr.jqgrow", "#" + $. Jgrid.jqID ($ TPID)). Pairar (
							function () {$ (this) addClass ("ui-state-foco");. $ ("#" + $ jgrid.jqID (this.id), "#" + $ jgrid.jqID ($ TPID).. + "_FROZEN") addClass ("ui-state-foco");.}
							function () {$ (this) removeClass ("ui-state-foco");... $ ("#" + $ jgrid.jqID (this.id), "#" + $ jgrid.jqID ($ TPID) + "_FROZEN") removeClass ("ui-state-foco");.}
						);
					}
					btbl = null;
				});
				if (! $ t.grid.hDiv.loading) {
					. $ ($ T) triggerHandler ("jqGridAfterGridComplete");
				}
				$ TpfrozenColumns = true;
			}
		});
	},
	destroyFrozenColumns: function () {
		voltar this.each (function () {
			Se {return;} (this.grid!)
			if (this.p.frozenColumns === true) {
				var $ t = this;
				. $ ($ T.grid.fhDiv) remove ();
				. $ ($ T.grid.fbDiv) remove ();
				$ T.grid.fhDiv = null; $ t.grid.fbDiv = null;
				. $ (This) desvincular ('setFrozenColumns.');
				if ($ tphoverrows === true) {
					var ptr;
					$ ("#" + $. Jgrid.jqID ($ TPID)). Bind ('mouseover', function (e) {
						ptr = $ (e.target) mais próximo ("tr.jqgrow").;
						if ($ (PTR). attr ("class")! == "ui-subgrid") {
						$ (PTR) addClass ("ui-state-pairar").;
					}
					}). Ligar ('mouseout', function (e) {
						ptr = $ (e.target) mais próximo ("tr.jqgrow").;
						$ (PTR) removeClass ("ui-state-pairar").;
					});
				}
				this.p.frozenColumns = false;
			}
		});
	}
});
}) (JQuery);
/ *
 * JqModal - Minimalista Modaling com jQuery
 * (Http://dev.iceburg.net/jquery/jqmodal/)
 *
 * Copyright (c) 2007,2008 Brice Burgess <bhb@iceburg.net>
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl.html
 * 
 * $ Version: 07/06/2008 + r13
 * /
(Function ($) {
$. Fn.jqm = function (o) {
var p = {
overlay: 50,
closeoverlay: true,
overlayClass: 'jqmOverlay',
closeClass: 'jqmClose',
provocar: '. jqModal',
ajax: F,
ajaxText:'',
alvo: F,
modal: F,
ToTop: F,
onShow: F,
OnHide: F,
onLoad: F
};
voltar this.each (function () {if (this._jqm) return H [this._jqm] c = $ estender ({}, H [this._jqm] c, o);... s + +; this._jqm = s;
H [s] = {c: $ estender (p, $ jqm.params, o.), A: F, w: $ (this) addClass (+ s 'jqmID'), s:.. S};
if (p.trigger) $ (this) jqmAddTrigger (p.trigger).;
});};

. $ Fn.jqmAddClose = function (e) {hs de retorno (isto, e, 'jqmHide');};
. $ Fn.jqmAddTrigger = function (e) {return hs (este, e, 'jqmShow');};
. $ Fn.jqmShow = function (t) {return this.each (. Function () {$ jqm.open (this._jqm, t);});};
. $ Fn.jqmHide = function (t) {return this.each (. Function () {$ jqm.close (this._jqm, t)});};

$. Jqm = {
hash: {},
'.': open função (s, t) {var h = H [s], c = hc, cc = + c.closeClass, z = (parseInt (hwcss ('z-index'))); z = ( ? z> 0) z: 3000; var F; ht = t; ha = true; hwcss ('z-index', z);
 if (c.modal) {if setTimeout (A [0]!) (function () {L ('bind');}, 1); A.push (s);}
 else if (c.overlay> 0) {if (c.closeoverlay) hwjqmAddClose (o);}
 mais o = F;

 ho = (o) o.addClass (c.overlayClass) prependTo ("corpo"):. F;

 if (c.ajax) {var r = c.target | | hw, u = c.ajax; r = (r typeof == 'string') $ (r, hw): $ (r); u = (? ? u.substr (0,1) == '@') $ (. t) attr (u.substring (1)): u;
  r.html(c.ajaxText).load(u,function(){if(c.onLoad)c.onLoad.call(this,h);if(cc)hwjqmAddClose($(cc,hw));e(h);});}
 else if (cc) hwjqmAddClose ($ (cc, hw));

 if (c.toTop && h.o) hwbefore ('<span id="jqmP'+hw[0]._jqm+'"> </ span>') insertAfter (ho).;	
 ? (C.onShow) c.onShow (h): hwshow (); e (h); regresso F;
},
perto:; (! ha) function (s) {var h = H [s] se voltar F; ha = F;
 se (A [0]) {A.pop (); se L ('desacoplar') (A [0]!);}
 .. if (hctoTop && h.o) $ (. + hw '# jqmP' [0] _jqm) depois (hw) remove ();
 if (hconHide) hconHide (h); else {hwhide (); if (ho) horemove ();} return F;
},
params: {}};
var s = 0, H = $. jqm.hash, A = [], F = falso,
e = function (h) {f (h);},
f = function (h) {. try {$ (': Entrada: visível ", hw) [0] se concentrar ();} catch (_) {}},
L = function (t) {$ (document) [t] ("keypress", m) [t] ("KeyDown", m) [t] ("mousedown", m);}
m = function (e) {var h = H [A [a.length-1]], r = (! $. (e.target) pais (+ HS) [0] 'jqmID.') if (r ) {$ {var $ self = $ (this), offset = $ self.offset () (+ HS) cada (function ('jqmID.'.); if (offset.top <= e.pageY && e.pageY <= offset.top + $ self.height () && offset.left <= e.pageX && e.pageX <= offset.left + $ self.width ()) {r = false; return false;}}); f ( h);} retornar r;!}
hs = function (w, t, c) {return w.each (function () {var s = this._jqm; $ (t) cada (function () {.
 Se {this [c] = []; $ (this) click (function () {for (var i in {jqmShow (este [c]!): 1, jqmHide:) for (var s neste [1}. i]) if (H [este [i] [s]]) H [este [i] [s]] w [i] (this);. voltar F;});.} isso [c] empurrar (s );});});};
}) (JQuery) ;/ *
 * JqDnR - minimalista Drag'n'Resize para jQuery.
 *
 * Copyright (c) 2007 Brice Burgess <bhb@iceburg.net>, http://www.iceburg.net
 * Licenciado sob a Licença MIT:
 * Http://www.opensource.org/licenses/mit-license.php
 * 
 * $ Versão: 2007.08.19 + r2
 * /

(Function ($) {
. $ Fn.jqDrag = function (h) {return i (este, h, 'd');};
. $ Fn.jqResize = function (h, ar) {return i (este, h, 'r', ar);};
$. JqDnR = {
	dnr: {},
	e: 0,
	arrasto: function (v) {
		if (Mc == 'd') {E.css ({left: M.X + v.pageX-M.pX, top: M.Y + v.pageY-M.pY});}
		else {
			E.css ({width: Math.max (v.pageX-M.pX + MW, 0), altura: Math.max (v.pageY-M.pY + MH, 0)});
			if (M1) {E1.css ({width: Math.max (v.pageX-M1.pX + M1.W, 0), altura: Math.max (v.pageY-M1.pY + M1.H, 0 )});}
		}
		return false;
	},
	parar: function () {
		/ / E.css ('opacidade', Mo);
		. $ (Document) desvincular ('mousemove', J.drag) desvincular ('mouseup', J.stop).;
	}
};
var J = $. jqDnR, M = J.dnr, E = Je, E1, M1,
i = function (e, h, k, aR) {
	voltar e.each (function () {
		h = (h) $ (h, e): e;?
		h.bind ('mousedown', {e: e, k: k}, function (v) {
			var d = v.data, p = {}; E = de; E1 = aR? $ (AR): false;
			/ / Utilização tentativa de dimensões de plugins para corrigir problemas do IE
			if (E.css ('position') = 'parente'!) {try {E.position (p);} catch (e) {}}
			M = {
				X: p.left | | f ("esquerda") | | 0,
				Y: p.top | | f ('top') | | 0,
				W:. F ('width') | | E [0] scrollWidth | | 0,
				H:. F ('altura') | | E [0] scrollHeight | | 0,
				PX: v.pageX,
				pY: v.pageY,
				k: dk
				/ / O: E.css ('opacidade')
			};
			/ / Também redimensionar
			if (E1 && dk! = 'd') {
				M1 = {
					X: p.left | | f1 ("esquerda") | | 0,
					Y: p.top | | f1 ('top') | | 0,
					. W: E1 [0] offsetWidth | | f1 ("largura") | | 0,
					. H: E1 [0] offsetHeight | | f1 ('altura') | | 0,
					PX: v.pageX,
					pY: v.pageY,
					k: dk
				};
			} Else {M1 = false;}			
			/ / E.css ({opacity: 0.8});
			if ($ ("input.hasDatepicker", E [0]) [0]) {
			try {$ ("input.hasDatepicker", E [0]) datepicker ('esconder');.} catch (DPE) {}
			}
			.. $ (Document) mousemove (. $ JqDnR.drag) mouseup ($ jqDnR.stop.);
			return false;
		});
	});
},
f = function (k) {return parseInt (E.css (k), 10) | | false;}
f1 = function (k) {return parseInt (E1.css (k), 10) | | false;};
}) (JQuery) ;/ *
	O trabalho a seguir é licenciado sob Creative Commons GNU LGPL License.

	Trabalho original:

	Licença: http://creativecommons.org/licenses/LGPL/2.1/
	Autor: Stefan Goessner/2006
	Web: http://goessner.net/ 

	Modificações feitas:

	Version: 0.9-p5
	Descrição: Reestruturação código, JSLint validados (sem espaços em branco rigorosos),
	             manuseio adicional de matrizes vazias, cadeias vazias, e int / flutua valores.
	Autor: Michael SchÃ ¸ ler/2008-01-29
	Web: http://michael.hinnerup.net/blog/2008/01/26/converting-json-to-xml-and-xml-to-json/
	
	Descrição: json2xml adicionou suporte para converter funções como CDATA
	             por isso vai ser fácil de escrever personagens que causam alguns problemas quando converso
	Autor: Tony Tomov
* /

/ * Alerta global * /
var xmlJsonClass = {
	/ / Param "xml": Elemento ou nó DOM documento.
	/ / "Guia" Param: Tab ou string travessão para formatação de saída bastante omitir ou usar string vazia "" para suprimir.
	/ / Retorna: string JSON
	xml2json: function (xml, tab) {
		if (xml.nodeType === 9) {
			/ / Nó de documento
			xml = xml.documentElement;
		}
		var NWS = this.removeWhite (xml);
		var obj = this.toObj (NWS);
		var json = this.toJson (obj, xml.nodeName, "\ t");
		return "{\ n" + guia + (? guia json.replace (/ \ t / g, tab): json.replace (/ \ t | \ n / g, "")) + "\ n}";
	},

	/ / Param "o": objeto JavaScript
	/ / "Guia" Param: guia ou corda travessão para formatação de saída bastante omitir ou usar string vazia "" para suprimir.
	/ / Retorna: string XML
	json2xml: function (o, guia) {
		var toXML = function (v, nome, ind) {
			var xml = "";
			var i, n;
			if (v Matriz instanceof) {
				if (v.length === 0) {
					xml + = ind + "<" + nome + "> __EMPTY_ARRAY_ </" + nome + "> \ n";
				}
				else {
					for (i = 0, n = v.length; i <n; i + = 1) {
						var sXML = ind + toXML (v [i], nome, ind + "\ t") + "\ n";
						xml + = sXML;
					}
				}
			}
			else if (typeof (v) === "objeto") {
				var hasChild = false;
				xml + = ind + "<" + nome;
				var m;
				para (m em v), se (v.hasOwnProperty (m)) {
					if (m.charAt (0) === "@") {
						xml + = "" + m.substr (1) + "= \". "+ v [m] toString () +" \ "";
					}
					else {
						hasChild = true;
					}
				}
				xml + = hasChild? ">": "/>";
				if (hasChild) {
					para (m em v), se (v.hasOwnProperty (m)) {
						if (m === "# texto") {
							xml + = v [m];
						}
						else if (m === "# cdata") {
							"<[+ v [m] +"] xml + =! CDATA ["]>";
						}
						else if (m.charAt (0)! == "@") {
							xml + = toXML (v [m], m, ind + "\ t");
						}
					}
					xml + = (? xml.charAt (xml.length - 1) === "\ n" ind: "") + "</" + nome + ">";
				}
			}
			else if (typeof (v) === "função") {
				"<[+ v +"] xml + = ind + "<" + nome + ">" +! CDATA ["]>" + "</" + nome + ">";
			}
			else {
				if (v === indefinido) {v = "";}
				if (v.toString () === "\" \ "" | |. v.toString () comprimento === 0) {
					xml + = ind + "<" + nome + "> __EMPTY_STRING_ </" + nome + ">";
				} 
				else {
					xml + = ind + "<" + nome + ">" + v.toString () + "</" + nome + ">";
				}
			}
			retornar xml;
		};
		var xml = "";
		var m;
		para (m em o) if (o.hasOwnProperty (m)) {
			xml + = toXML (f [m], m, "");
		}
		guia retornar? xml.replace (/ \ t / g, separador): xml.replace (/ \ t | \ n / g, "");
	},
	Métodos / / Interna
	toObj: function (xml) {
		var o = {};
		var FuncTest = / função / i;
		if (xml.nodeType === 1) {
			/ / Nó de elemento ..
			if (xml.attributes.length) {
				/ / Elemento com atributos ..
				var i;
				for (i = 0; i <xml.attributes.length; i + = 1) {
					. o [. "@" + xml.attributes [i] nodeName] = (. xml.attributes [i] nodeValue | | "") toString ();
				}
			}
			if (xml.firstChild) {
				/ / Elemento tem nós filhos ..
				var textChild = 0, cdataChild = 0, hasElementChild = false;
				var n;
				para (n = xml.firstChild, n, n = n.nextSibling) {
					if (n.nodeType === 1) {
						hasElementChild = true;
					}
					else if (n.nodeType === 3 && n.nodeValue.match (/ [^ \ f \ n \ r \ t \ v] /)) {
						/ / Texto não-espaço em branco
						textChild + = 1;
					}
					else if (n.nodeType === 4) {
						/ / Cdata nó seção
						cdataChild + = 1;
					}
				}
				if (hasElementChild) {
					if (textChild <2 && cdataChild <2) {
						/ / Elemento estruturado com evtl. um único texto e / ou nó CDATA ..
						this.removeWhite (xml);
						para (n = xml.firstChild, n, n = n.nextSibling) {
							if (n.nodeType === 3) {
								/ / Nó de texto
								o ["# texto"] = this.escape (n.nodeValue);
							}
							else if (n.nodeType === 4) {
								/ / Node cdata
								if (FuncTest.test (n.nodeValue)) {
									o [n.nodeName] = [o [n.nodeName], n.nodeValue];
								} Else {
									o ["# cdata"] = this.escape (n.nodeValue);
								}
							}
							else if (o [n.nodeName]) {
								/ / Ocorrência de múltiplos elementos ..
								if (o [n.nodeName] instanceof Array) {
									o [n.nodeName] [. o [n.nodeName] comprimento] = this.toObj (n);
								}
								else {
									o [n.nodeName] = [o [n.nodeName], this.toObj (n)];
								}
							}
							else {
								/ / Primeira ocorrência do elemento ..
								o [n.nodeName] = this.toObj (n);
							}
						}
					}
					else {
						/ / Conteúdo misto
						if (xml.attributes.length!) {
							o = this.escape (this.innerXml (xml));
						}
						else {
							o ["# texto"] = this.escape (this.innerXml (xml));
						}
					}
				}
				else if (textChild) {
					/ / Texto puro
					if (xml.attributes.length!) {
						o = this.escape (this.innerXml (xml));
						if (S === "__EMPTY_ARRAY_") {
							o = "[]";
						} Else if (o === "__EMPTY_STRING_") {
							o = "";
						}
					}
					else {
						o ["# texto"] = this.escape (this.innerXml (xml));
					}
				}
				else if (cdataChild) {
					/ / Cdata
					if (cdataChild> 1) {
						o = this.escape (this.innerXml (xml));
					}
					else {
						para (n = xml.firstChild, n, n = n.nextSibling) {
							if (FuncTest.test (xml.firstChild.nodeValue)) {
								o = xml.firstChild.nodeValue;
								break;
							} Else {
								o ["# cdata"] = this.escape (n.nodeValue);
							}
						}
					}
				}
			}
			if (xml.attributes.length! &&! xml.firstChild) {
				o = null;
			}
		}
		else if (xml.nodeType === 9) {
			/ / Document.node
			o = this.toObj (xml.documentElement);
		}
		else {
			alert ("tipo de nó não tratada:" + xml.nodeType);
		}
		devolver o;
	},
	toJson: function (o, nome, ind, wellform) {
		if (wellform === indefinido) wellform = true;
		var json = nome? ("\" "+ Nome +" \ ""): "", tab = "\ t", nova linha = "\ n";
		if (wellform!) {
			tab = ""; nova linha = "";
		}

		if (S === "[]") {
			json + = (nome ": []": "[]");
		}
		else if (o instanceof Array) {
			var n, i, ar = [];
			for (i = 0, n = o.length; i <n; i + = 1) {
				ar [i] = this.toJson (o [i], "", ind + tab, wellform);
			}
			json + = (nome? ": [": "[") + (ar.length> 1 (nova linha + ind + guia + ar.join ("," + newline + ind + tab) + newline + ind)?: ar.join ("")) + "]";
		}
		else if (o === null) {
			json + = (nome && ":") + "null";
		}
		else if (typeof (o) === "objeto") {
			var arr = [], m;
			for (m em o) {
				if (o.hasOwnProperty (m)) {
					arr [arr.Length] = this.toJson (o [m], m, ind + tab, wellform);
			}
		}
			json + = (nome? ": {": "{") + (arr.Length> 1 (nova linha + ind + guia + arr.join ("," + newline + ind + tab) + newline + ind)?: arr.join ("")) + "}";
		}
		else if (typeof (o) === "string") {
			/ *
			var objRegExp = / (.? ^ - \ d + \ \ d * $) /;
			var FuncTest = / função / i;
			var os = o.toString ();
			if (objRegExp.test (os) | | FuncTest.test (os) | | OS === "false" | | OS === "true") {
				/ / Int ou float
				json + = (nome && ":") + "\" "+ OS +" \ "";
			} 
			else {
			* /
				json + = (nome && ":"). + "\" "+ o.replace (/ \ \ / g, '\ \ \ \') replace (/ \" / g, '\ \' ") +" \ "";
			/ /}
			}
		else {
			json + = (nome && ":") + o.toString ();
		}
		retornar json;
	},
	InnerXml: function (node) {
		var s = "";
		if ("innerHTML" no nó) {
			s = node.innerHTML;
		}
		else {
			var asXML = function (n) {
				var s = "", i;
				if (n.nodeType === 1) {
					s + = "<" + n.nodeName;
					for (i = 0; i <n.attributes.length; i + = 1) {
						. s + = "+". n.attributes [i] nodeName + "= \" "+ (. n.attributes [i] nodeValue | |" ") toString () +" \ "";
					}
					if (n.firstChild) {
						s + = ">";
						for (var c = n.firstChild, c, c = c.nextSibling) {
							s + = asXML (c);
						}
						s + = "</" + n.nodeName + ">";
					}
					else {
						s + = "/>";
					}
				}
				else if (n.nodeType === 3) {
					s + = n.nodeValue;
				}
				else if (n.nodeType === 4) {
					"<[+ n.nodeValue +"] s + =! CDATA ["]>";
				}
				retornar s;
			};
			for (var c = Node.FirstChild, c, c = c.nextSibling) {
				s + = asXML (c);
			}
		}
		retornar s;
	},
	escapar: function (txt) {
		voltar txt.replace (/ [\ \] / g, "\ \ \ \"). replace (/ [\ "] / g, '\ \"'). replace (/ [\ n] / g, '\ \ n '). replace (/ [\ r] / g,' \ \ r ');
	},
	removeWhite: function (e) {
		e.normalize ();
		var n;
		para (n = e.firstChild; n;) {
			if (n.nodeType === 3) {
				/ / Nó de texto
				if (! n.nodeValue.match (/ [^ \ f \ n \ r \ t \ v] /)) {
					/ / Pure nó de texto de espaço em branco
					var nxt = n.nextSibling;
					e.removeChild (n);
					n = nxt;
				}
				else {
					n = n.nextSibling;
				}
			}
			else if (n.nodeType === 1) {
				/ / Nó de elemento
				this.removeWhite (n);
				n = n.nextSibling;
			}
			else {
				/ / Qualquer outro nó
				n = n.nextSibling;
			}
		}
		e regresso;
	}
} ;/ *
**
 * Formatador de valores, mas a maior parte dos valores para se jqGrid
 * Parte deste foi inspirado e baseado em como YUI faz o datagrid mesa, mas na moda jQuery
 * Estamos tentando mantê-lo o mais leve possível
 * Josué Burnett josh@9ci.com	
 * Http://www.greenbill.com
 *
 * Mudanças de Tony Tomov tony@trirand.com
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
 * 
** /
/ * Jshint eqeqeq: false * /
/ * JQuery globais * /

(Function ($) {
"Use strict";	
	. $ Fmatter = {};
	/ / opta pode ser id: id linha para a linha, RowData: os dados para a linha, colModel: o modelo da coluna para esta coluna
	/ / Example {id: 1234,}
	$. Estender ($. Fmatter, {
		isBoolean: function (o) {
			retornar typeof o === 'boolean';
		},
		IsObject: function (o) {
			retorno (o && (typeof o === 'objeto' | | $ isFunction (o)).) | | false;
		},
		isString: function (o) {
			retornar typeof o === 'string';
		},
		IsNumber: function (o) {
			retornar typeof o === 'número' && isFinite (o);
		},
		isValue: function (o) {
			retorno (this.isObject (o) | | this.isString (o) | | this.isNumber (o) | | this.isBoolean (O));
		},
		isEmpty: function (o) {
			if (! this.isString (o) && this.isValue (o)) {
				return false;
			}
			if (! this.isValue (o)) {
				return true;
			}
			... o = $ trim (o) replace (/ \ \ ;/ ig,'') replace (/ \ \ ;/ ig,'');
			devolver o === "";	
		}
	});
	$. Fn.fmatter = function (formatType, cellval, opta, rwd, ato) {
		/ / Construir principais opções antes elemento iteração
		var v = cellval;
		. opta = $ estender ({}, $ jgrid.formatter, opta.);

		try {
			.. v = $ fn.fmatter [formatType] call (este, cellval, opta, rwd, ato);
		} Catch (fe) {}
		retornar v;
	};
	$. Fmatter.util = {
		/ / Tomado de utils YAHOO
		NumberFormat: function (nData, opta) {
			if (! $. fmatter.isNumber (nData)) {
				nData * = 1;
			}
			if ($. fmatter.isNumber (nData)) {
				var bNegative = (nData <0);
				var sOutput = String (nData);
				"". | var sDecimalSeparator = opts.decimalSeparator |;
				var nDotIndex;
				if ($. fmatter.isNumber (opts.decimalPlaces)) {
					/ / Rodada à casa decimal correta
					var nDecimalPlaces = opts.decimalPlaces;
					var nDecimal = Math.pow (10, nDecimalPlaces);
					sOutput = String (Math.round (nData * nDecimal) / nDecimal);
					nDotIndex = sOutput.lastIndexOf (".");
					if (nDecimalPlaces> 0) {
					/ / Adiciona o separador decimal
						if (nDotIndex <0) {
							sOutput + = sDecimalSeparator;
							nDotIndex = sOutput.length-1;
						}
						/ / Substituir o "."
						else if (sDecimalSeparator! == ".") {
							sOutput = sOutput.replace (".", sDecimalSeparator);
						}
					/ / Adiciona zeros faltantes
						while ((sOutput.length - 1 - nDotIndex) <nDecimalPlaces) {
							sOutput + = "0";
						}
					}
				}
				if (opts.thousandsSeparator) {
					var sThousandsSeparator = opts.thousandsSeparator;
					nDotIndex = sOutput.lastIndexOf (sDecimalSeparator);
					nDotIndex = (nDotIndex> -1)? nDotIndex: sOutput.length;
					var sNewOutput = sOutput.substring (nDotIndex);
					var nCount = -1, i;
					for (i = nDotIndex; i> 0; i -) {
						nCount + +;
						if ((nCount% 3 === 0) && (i == nDotIndex) && (bNegative |! | (i> 1))) {
							sNewOutput = sThousandsSeparator + sNewOutput;
						}
						sNewOutput = sOutput.charAt (i-1) + sNewOutput;
					}
					sOutput = sNewOutput;
				}
				/ / Prefixo Prepend
				sOutput = (opts.prefix)? opts.prefix + sOutput: sOutput;
				/ / Acrescentar sufixo
				sOutput = (opts.suffix)? sOutput + opts.suffix: sOutput;
				voltar sOutput;
				
			}
			voltar nData;
		}
	};
	$. Fn.fmatter.defaultFormat = function (cellval, opta) {
		return ($. fmatter.isValue (cellval) && cellval! == "")? cellval: opts.defaultValue | | "";
	};
	$. Fn.fmatter.email = function (cellval, opta) {
		if (! $. fmatter.isEmpty (cellval)) {
			voltar "<a href=\"mailto:" + + cellval "\">" + cellval + "</ a>";
		}
		return $ fn.fmatter.defaultFormat (cellval, opta).;
	};
	$. Fn.fmatter.checkbox = function (CVAL, opta) {
		var op = $ estender ({}, opts.checkbox), ds.;
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if (op.disabled === true) {ds = "disabled = \" disabled \ "";} else {ds = "";}
		if ($ fmatter.isEmpty (CVAL) | | CVAL === indefinido.) {CVAL = $ fn.fmatter.defaultFormat (CVAL, op);.}
		CVAL = String (CVAL);
		CVAL = (CVAL + "") toLowerCase ().;
		var bchk = cval.search (/ (false | f | 0 | nenhuma | n | off | indefinido) / i) <0? "Checked = 'marcada'": "";
		voltar "<input type=\"checkbox\"" + bchk + "value=\""+ cval+"\" offval=\"no\" "+ds+ "/>";
	};
	$. Fn.fmatter.link = function (cellval, opta) {
		var op = {target: opts.target};
		alvo var = "";
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if (op.target) {target = 'target =' + op.target;}
		if (! $. fmatter.isEmpty (cellval)) {
			voltar "<a "+target+" href=\"" + + cellval "\">" + cellval + "</ a>";
		}
		return $ fn.fmatter.defaultFormat (cellval, opta).;
	};
	$. Fn.fmatter.showlink = function (cellval, opta) {
		var op = {baseLinkUrl: opts.baseLinkUrl, showAction: opts.showAction, AddParam: opts.addParam | | "," alvo: opts.target, idName: opts.idName},
		target = "", idUrl;
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if (op.target) {target = 'target =' + op.target;}
		idUrl = op.baseLinkUrl + + + op.showAction op.idName + '=' + + opts.rowId op.addParam '?';
		if ($ fmatter.isString (cellval) |. |. $ fmatter.isNumber (cellval)) {/ / adiciona um presente mesmo que a sua cadeia em branco
			voltar "<a "+target+" href=\"" + + idUrl "\">" + cellval + "</ a>";
		}
		return $ fn.fmatter.defaultFormat (cellval, opta).;
	};
	$. Fn.fmatter.integer = function (cellval, opta) {
		var op = $ estender ({}, opts.integer).;
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if ($. fmatter.isEmpty (cellval)) {
			voltar op.defaultValue;
		}
		return $ fmatter.util.NumberFormat (cellval, op).;
	};
	$. Fn.fmatter.number = function (cellval, opta) {
		var op = $ estender ({}, opts.number).;
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if ($. fmatter.isEmpty (cellval)) {
			voltar op.defaultValue;
		}
		return $ fmatter.util.NumberFormat (cellval, op).;
	};
	$. Fn.fmatter.currency = function (cellval, opta) {
		var op = $ estender ({}, opts.currency).;
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if ($. fmatter.isEmpty (cellval)) {
			voltar op.defaultValue;
		}
		return $ fmatter.util.NumberFormat (cellval, op).;
	};
	$. Fn.fmatter.date = function (cellval, opta, rwd, ato) {
		var op = $ estender ({}, opts.date).;
		if (opts.colModel! == indefinidos && opts.colModel.formatoptions! == indefinidos) {
			op = $ estender ({}, op, opts.colModel.formatoptions).;
		}
		if (! op.reformatAfterEdit && ato === "editar") {
			return $ fn.fmatter.defaultFormat (cellval, opta).;
		}
		if (! $. fmatter.isEmpty (cellval)) {
			. voltar $ jgrid.parseDate (op.srcformat, cellval, op.newformat, op);
		}
		return $ fn.fmatter.defaultFormat (cellval, opta).;
	};
	$. Fn.fmatter.select = function (cellval, opta) {
		/ / Específico jqGrid
		cellval = String (cellval);
		var oSelect = false, ret = [], sep, delim;
		if (! == opts.colModel.formatoptions indefinido) {
			oSelect = opts.colModel.formatoptions.value;
			setembro = opts.colModel.formatoptions.separator === indefinido? ":": Opts.colModel.formatoptions.separator;
			delim = opts.colModel.formatoptions.delimiter === indefinido? ";": Opts.colModel.formatoptions.delimiter;
		} Else if (! == Opts.colModel.editoptions indefinidos) {
			oSelect = opts.colModel.editoptions.value;
			setembro = opts.colModel.editoptions.separator === indefinido? ":": Opts.colModel.editoptions.separator;
			delim = opts.colModel.editoptions.delimiter === indefinido? ";": Opts.colModel.editoptions.delimiter;
		}
		if (oSelect) {
			var MSL = opts.colModel.editoptions.multiple === verdade? verdadeiro: false,
			Scell ​​= [], sv;
			if (MSL) {Scell ​​= cellval.split (",");. Scell ​​= $ mapa (. Scell, function (n) {return $ trim (n);});}
			if ($. fmatter.isString (oSelect)) {
				/ / Mybe aqui podemos usar alguns cache com cuidado??
				var so = oSelect.split (delimitador), j = 0, i;
				for (i = 0; i <so.length; i + +) {
					sv = assim [i] split (setembro).;
					if (sv.length> 2) {
						. sv [1] = $ map (sv, function (n, i) {if (i> 0) {return n;}}) join (setembro).;
					}
					if (MSL) {
						if ($. inArray (sv [0], Scell)> -1) {
							ret [j] = sv [1];
							j + +;
						}
					} Else if ($. Trim (sv [0]) === $. Trim (cellval)) {
						ret [0] = sv [1];
						break;
					}
				}
			} Else if ($. Fmatter.isObject (oSelect)) {
				/ / Isto é mais rápido
				if (MSL) {
					ret = $. mapa (Scell, function (n) {
						retornar oSelect [n];
					});
				} Else {
					ret [0] = oSelect [cellval] | | "";
				}
			}
		}
		cellval = ret.join (",");
		voltar cellval === ""? $ Fn.fmatter.defaultFormat (cellval, opta):. Cellval;
	};
	$. Fn.fmatter.rowactions = function (act) {
		var $ tr = $ (this). mais próximo ("tr.jqgrow"),
			livrar = $ tr.attr ("id"),
			$ Id = $ (this). Mais próximo ("table.ui-jqgrid-btable"). Attr ('id'). Replace (/ _FROZEN ([^ _] *) $ /, '$ 1'),
			$ Grade = $ ("#" + $ id),
			$ T = $ grade [0],
			p = $ tp,
			cm = p.colModel [$. jgrid.getCellIndex (this)],
			$ ActionsDiv = cm.frozen? $ ("Tr #" + livrar + "td: eq (" + $ jgrid.getCellIndex (this) + ")> div", $ grid.):. $ (This) pai (),
			op = {
				chaves: false,
				onedit: null, 
				onSuccess: null, 
				afterSave: null,
				onError: null,
				afterRestore: null,
				extraparam: {},
				url: null,
				restoreAfterError: true,
				mtype: "POST",
				delOptions: {},
				editOptions: {}
			},
			saverow = function (rowid, res) {
				Se {op.afterSave.call ($ t, rowid, res);} ($ isFunction (op.afterSave).)
				. $ ActionsDiv.find ("div.ui-inline-edit, div.ui-inline-del") show ();
				. $ ActionsDiv.find ("div.ui-inline-salvar, div.ui-inline-cancel") hide ();
			},
			restorerow = function (rowid) {
				Se {op.afterRestore.call ($ t, rowid);} ($ isFunction (op.afterRestore).)
				. $ ActionsDiv.find ("div.ui-inline-edit, div.ui-inline-del") show ();
				. $ ActionsDiv.find ("div.ui-inline-salvar, div.ui-inline-cancel") hide ();
			};

		if (! == cm.formatoptions indefinido) {
			op = $ estender (op, cm.formatoptions).;
		}
		if (! == p.editOptions indefinido) {
			op.editOptions = p.editOptions;
		}
		if (! == p.delOptions indefinido) {
			op.delOptions = p.delOptions;
		}
		if ($ tr.hasClass ("jqgrid-new-linha")) {
			op.extraparam [p.prmNames.oper] = p.prmNames.addoper;
		}
		var ACTOP = {
			chaves: op.keys,
			oneditfunc: op.onEdit,
			successfunc: op.onSuccess,
			url: op.url,
			extraparam: op.extraparam,
			aftersavefunc: saverow,
			errorfunc: op.onError,
			afterrestorefunc: restorerow,
			restoreAfterError: op.restoreAfterError,
			mtype: op.mtype
		};
		switch (act)
		{
			caso "editar":
				$ Grid.jqGrid ('editRow', livrar, ACTOP);
				. $ ActionsDiv.find ("div.ui-inline-edit, div.ui-inline-del") hide ();
				. $ ActionsDiv.find ("div.ui-inline-salvar, div.ui-inline-cancel") show ();
				$ Grid.triggerHandler ("jqGridAfterGridComplete");
				break;
			caso 'salvar':
				if ($ grid.jqGrid ('saveRow', livre, ACTOP)) {
					. $ ActionsDiv.find ("div.ui-inline-edit, div.ui-inline-del") show ();
					. $ ActionsDiv.find ("div.ui-inline-salvar, div.ui-inline-cancel") hide ();
					$ Grid.triggerHandler ("jqGridAfterGridComplete");
				}
				break;
			caso 'cancelar':
				$ Grid.jqGrid ('restoreRow', livrar, restorerow);
				. $ ActionsDiv.find ("div.ui-inline-edit, div.ui-inline-del") show ();
				. $ ActionsDiv.find ("div.ui-inline-salvar, div.ui-inline-cancel") hide ();
				$ Grid.triggerHandler ("jqGridAfterGridComplete");
				break;
			caso 'del':
				$ Grid.jqGrid ('delGridRow', livre, op.delOptions);
				break;
			case 'formedit':
				$ Grid.jqGrid ('setSelection', livrar);
				$ Grid.jqGrid ('editGridRow', livre, op.editOptions);
				break;
		}
	};
	$. Fn.fmatter.actions = function (cellval, opta) {
		var op = {chaves: falso, editbutton: true, delbutton: true, editformbutton: false},
			rowid = opts.rowId, str = "", ocl;
		if (! == opts.colModel.formatoptions indefinido) {
			op = $ estender (op, opts.colModel.formatoptions).;
		}
		if (rowid === indefinido | | $ fmatter.isEmpty (rowid).) {return "";}
		if (op.editformbutton) {
			ocl = "id = 'jEditButton_" + rowid + "' onclick = jQuery.fn.fmatter.rowactions.call (isto ', formedit'); onmouseover = jQuery (this) addClass ('ui-state-pairar');. onmouseout = jQuery (this) removeClass ('ui-state-pairar'); ".;
			str + = "<div title = '" + $ jgrid.nav.edittitle +' ". 'float: left; cursor: pointer;" style = class =' ​​pg-ui-ui-div inline-edit '"+ ocl +" > <span class='ui-icon ui-icon-pencil'> </ span> </ div> ";
		} Else if (op.editbutton) {
			ocl = "id = 'jEditButton_" + rowid + "' onclick = jQuery.fn.fmatter.rowactions.call (this," editar "); onmouseover = jQuery (this) addClass ('ui-state-pairar');. onmouseout = jQuery (this) removeClass ('ui-state-pairar'). ";
			str + = "<div title = '" + $ jgrid.nav.edittitle +' ". 'float: left; cursor: pointer;" style = class =' ​​pg-ui-ui-div inline-edit '"+ ocl +" > <span class='ui-icon ui-icon-pencil'> </ span> </ div> ";
		}
		if (op.delbutton) {
			ocl = "id = 'jDeleteButton_" + rowid + "' onclick = jQuery.fn.fmatter.rowactions.call (this, 'del'); onmouseover = jQuery (this) addClass ('ui-state-pairar');. onmouseout = jQuery (this) removeClass ('ui-state-pairar'); ".;
			str + = "<div title = '". + $ jgrid.nav.deltitle + "' style =" float: left; margin-left: 5px; "class =" ui-ui pg-div-inline-del '"+ ocl + "> <span class='ui-icon ui-icon-trash'> </ span> </ div>";
		}
		ocl = "id = 'jSaveButton_" + rowid + "' onclick = jQuery.fn.fmatter.rowactions.call (this, 'salvar'); onmouseover = jQuery (this) addClass ('ui-state-pairar');. onmouseout = jQuery (this) removeClass ('ui-state-pairar'); ".;
		str + = "<div title='"+$.jgrid.edit.bSubmit+"' style='float:left;display:none' class='ui-pg-div ui-inline-save' "+ocl+"> <span class='ui-icon ui-icon-disk'> </ span> </ div> ";
		ocl = "id = 'jCancelButton_" + rowid + "' onclick = jQuery.fn.fmatter.rowactions.call (this, 'cancelar'); onmouseover = jQuery (this) addClass ('ui-state-pairar');. onmouseout = jQuery (this) removeClass ('ui-state-pairar'); ".;
		str + = "<div title = '" + $ jgrid.edit.bCancel + "."' float: left; display: none; margin-left: 5px; "style = class =" ui-PG-div ui-inline- cancelar '"+ ocl +"> <span class='ui-icon ui-icon-cancel'> </ span> </ div> ";
		voltar "<div style='margin-left:8px;'>" + str + "</ div>";
	};
	$. Unformat = function (cellval, opções, pos, cnt) {
		/ / Específico para jqGrid só
		var ret, formatType = options.colModel.formatter,
		op = options.colModel.formatoptions | | {}, setembro,
		re = / ([\. \ * \ _ \ '\ (\) \ {\} \ + \? \ \]) / g,
		unformatFunc = options.colModel.unformat | | ($ fn.fmatter [formatType] && $ fn.fmatter [formatType] unformat...);
		if (unformatFunc! == indefinido && $. isFunction (unformatFunc)) {
			ret = unformatFunc.call (este, $ (cellval) text (), opções, cellval.);
		} Else if (formatType! == Indefinido && $. Fmatter.isString (formatType)) {
			var opts = $ jgrid.formatter | | {}, stripTag.;
			switch (formatType) {
				case 'inteiro':
					op = $ estender ({}, opts.integer, op).;
					setembro = op.thousandsSeparator.replace (re, "\ \ $ 1");
					stripTag = new RegExp (setembro, "g");
					.. ret = $ (cellval) text () substituir (stripTag,'');
					break;
				caso "número":
					op = $ estender ({}, opts.number, op).;
					setembro = op.thousandsSeparator.replace (re, "\ \ $ 1");
					stripTag = new RegExp (setembro, "g");
					.. ret = $ (cellval) text () substituir (stripTag, "") substituir. (op.decimalSeparator, '.');
					break;
				caso "moeda":
					op = $ estender ({}, opts.currency, op).;
					setembro = op.thousandsSeparator.replace (re, "\ \ $ 1");
					stripTag = new RegExp (setembro, "g");
					ret = $ (cellval) text ().;
					if (op.prefix && op.prefix.length) {
						ret = ret.substr (op.prefix.length);
					}
					if (op.suffix && op.suffix.length) {
						ret = ret.substr (0, ret.length - op.suffix.length);
					}
					. ret = ret.replace (stripTag,'') substituir (op.decimalSeparator, '.');
					break;
				case 'caixa':
					var cbv = (options.colModel.editoptions)? options.colModel.editoptions.value.split (":"): ["Sim", "Não"];
					ret = $ ('input', cellval) é (": checked").? cbv [0]: cbv [1];
					break;
				caso 'selecionar':
					. ret = $ unformat.select (cellval, opções, pos, cnt);
					break;
				caso 'ações':
					retornar "";
				default:
					ret = $ (cellval) text ().;
			}
		}
		ret voltar! == indefinido? ret: cnt === verdade? . $ (Cellval) text (): $. Jgrid.htmlDecode (. $ (Cellval) html ());
	};
	$. Unformat.select = function (cellval, opções, pos, cnt) {
		/ / Case Spacial quando temos dados locais e realizar uma espécie
		/ / Cnt é definido como verdadeiro apenas em sortDataArray
		var ret = [];
		célula var = $ (cellval) text ().;
		if (cnt === true) {célula return;}
		. var op = $ estender ({}, options.colModel.formatoptions == indefinido options.colModel.formatoptions:? options.colModel.editoptions),
		setembro = op.separator === indefinido? ":": Op.separator,
		delim = op.delimiter === indefinido? ";": Op.delimiter;
		
		if (op.value) {
			var oSelect = op.value,
			MSL = op.multiple === verdade? verdadeiro: false,
			Scell ​​= [], sv;
			if (MSL) {Scell ​​= cell.split (",");. Scell ​​= $ mapa (. Scell, function (n) {return $ trim (n);});}
			if ($. fmatter.isString (oSelect)) {
				var so = oSelect.split (delimitador), j = 0, i;
				for (i = 0; i <so.length; i + +) {
					sv = assim [i] split (setembro).;
					if (sv.length> 2) {
						. sv [1] = $ map (sv, function (n, i) {if (i> 0) {return n;}}) join (setembro).;
					}					
					if (MSL) {
						if ($. Iñarra y (sv [1], Scell)> -1) {
							ret [j] = sv [0];
							j + +;
						}
					} Else if ($. Trim (sv) [1] === $. Trim (celular)) {
						ret [0] = sv [0];
						break;
					}
				}
			} Else if ($ fmatter.isObject (oSelect) |. |. $ IsArray (oSelect)) {
				if (MSL!) {Scell ​​[0] = célula;}
				ret = $. mapa (Scell, function (n) {
					var rv;
					$. Cada (oSelect, function (i, val) {
						if (val === n) {
							rv = i;
							return false;
						}
					});
					if (rv == indefinido!) {rv return;}
				});
			}
			retornar ret.join (",");
		}
		voltar célula | | "";
	};
	$. Unformat.date = function (cellval, opta) {
		var op = $ jgrid.formatter.date | | {}.;
		if (! == opts.formatoptions indefinido) {
			op = $ estender ({}, op, opts.formatoptions).;
		}		
		if (! $. fmatter.isEmpty (cellval)) {
			. voltar $ jgrid.parseDate (op.newformat, cellval, op.srcformat, op);
		}
		return $ fn.fmatter.defaultFormat (cellval, opta).;
	};
}) (JQuery);
/ * Jshint eqeqeq: false * /
/ * JQuery globais * /
(Function ($) {
/ *
 * JqGrid função comum
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/ 
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
* /
"Use strict";
$. Estender ($. Jgrid, {
/ / funções Modal
	ShowModal: function (h) {
		hwshow ();
	},
	closeModal: function (h) {
		hwhide () attr ("hidden-ária", "true").;
		if (ho) {horemove ();}
	},
	hideModal: function (selector, o) {
		. o = $ estender ({jqm: true, gb:''}, o | | {});
		if (o.onClose) {
			var oncret = o.gb && typeof o.gb === "string" && o.gb.substr (0,6) === "# gbox_"? o.onClose.call ($ ("#" + o.gb.substr (6)) [0], seletor): o.onClose (selector);
			if (typeof oncret === 'boolean' && oncret!) {return;}
		}
		if ($. fn.jqm && o.jqm === true) {
			. $ (Selector) attr ("hidden-ária", "true") jqmHide ().;
		} Else {
			if (o.gb! =='') {
				try {$ ("jqgrid-overlay:. primeiro", o.gb). hide ();} catch (e) {}
			}
			.. $ (Selector) hide () attr ("hidden-ária", "true");
		}
	},
Funções / / Ajudante
	findPos: function (obj) {
		var curleft = 0, curtop = 0;
		if (obj.offsetParent) {
			fazer {
				curleft + = obj.offsetLeft;
				curtop + = obj.offsetTop;
			} While (obj = obj.offsetParent);
			/ / Não mudam obj == obj.offsetParent
		}
		voltar [curleft, curtop];
	},
	createModal: function (SIDA, conteúdo, p, insertSelector, posSelector, appendsel, css) {
		. p = $ estender (true, {}, $ jgrid.jqModal | | {}, p.);
		var mw = document.createElement ('div'), rtlsup, auto = this;
		. css = $ estender ({}, css | | {});
		rtlsup = $ (p.gbox). attr ("dir") === "RTL"? verdadeiro: false;
		mw.className = "ui ui-widget-widget-content ui-corner-all ui-jqdialog";
		mw.id = aIDs.themodal;
		var mh = document.createElement ('div');
		mh.className = "ui-ui jqdialog-titlebar-widget-header ui-corner-all ui-helper-clearfix";
		mh.id = aIDs.modalhead;
		. $ (Mh) append ("<span class='ui-jqdialog-title'>" + p.caption + "</ span>");
		var Ahr = $ ("<a class='ui-jqdialog-titlebar-close ui-corner-all'> </ a>")
		. Pairar (function () {ahr.addClass ('ui-state-pairar');}
			function () {ahr.removeClass ('ui-state-pairar');})
		. Append ("<span class='ui-icon ui-icon-closethick'> </ span>");
		. $ (Mh) anexar (IAH);
		if (rtlsup) {
			mw.dir = "rtl";
			. $ (". Ui-jqdialog-título", mh) css ("flutuar", "direito");
			. $ (". Ui-jqdialog-titlebar de perto", mh) css ("esquerda", 0,3 + "em");
		} Else {
			mw.dir = "l";
			. $ (". Ui-jqdialog-título", mh) css ("flutuar", "esquerda");
			. $ (". Ui-jqdialog-titlebar de perto", mh) css ("right", 0,3 + "em");
		}
		var mc = document.createElement ('div');
		.. $ (Mc) addClass ("ui-widget-content ui-jqdialog-content") attr ("id", aIDs.modalcontent);
		. $ (Mc) anexar (conteúdo);
		mw.appendChild (MC);
		. $ (Mw) preceder (mh);
		if (appendsel === true) {. $ ('body') append (mw);} / / anexa como a primeira criança no corpo de diálogo de alerta
		else if (typeof appendsel === "string") {
			. $ (Appendsel) append (mw);
		.} Else {$ (mw) insertBefore (insertSelector);}
		. $ (Mw) css (css);
		if (p.jqModal === indefinido) {p.jqModal = true;} / / uso interno
		var coord = {};
		if ($. fn.jqm && p.jqModal === true) {
			if (p.left === 0 && p.top === 0 && p.overlay) {
				var pos = [];
				pos = $ jgrid.findPos (posSelector).;
				p.left = pos [0] + 4;
				p.top = pos [1] + 4;
			}
			coord.top = p.top + "px";
			coord.left = p.left;
		} Else if (p.left == 0 | |! P.top == 0) {
			coord.left = p.left;
			coord.top = p.top + "px";
		}
		$ ("A.ui-jqdialog-titlebar de perto", mh). Click (function () {
			var oncm = $ ("#" + $ jgrid.jqID (aIDs.themodal).) dados ("onClose") | | p.onClose.;
			var gboxclose = $ ("#" + $ jgrid.jqID (aIDs.themodal).) dados ("gbox") | | p.gbox.;
			self.hideModal (. "#" + $ jgrid.jqID (aIDs.themodal), {gb: gboxclose, jqm: p.jqModal, OnClose: oncm});
			return false;
		});
		if (p.width === 0 | | p.width!) {p.width = 300;}
		if (p.height === 0 | | p.height!) {p.height = 200;}
		if (p.zIndex!) {
			... var Parentz = $ (insertSelector) pais ("* [role = diálogo]") filtro (': first') css ("z-index");
			if (Parentz) {
				p.zIndex = parseInt (Parentz, 10) 2;
			} Else {
				p.zIndex = 950;
			}
		}
		var rtlt = 0;
		if (rtlsup && coord.left &&! appendsel) {
			rtlt = $ (p.gbox) largura () - (isNaN (p.width) parseInt (p.width, 10): 0?) - 8 / / fazer.
		/ / Para o caso
			coord.left = parselnt (coord.left, 10) + parselnt (rtlt, 10);
		}
		if () {coord.left coord.left + = "px";}
		$ (MW). Css ($. Estender ({
			width: isNaN (p.width)? "Auto": p.width + "px",
			height: isNaN (p.height)? "Auto": p.height + "px",
			zIndex: p.zIndex,
			overflow: 'escondido'
		}, Coord))
		. Attr ({tabIndex: "-1", "papel": "diálogo", "aria-labelledby": aIDs.modalhead, "aria-oculto": "true"});
		if (p.drag === indefinido) {p.drag = true;}
		if (p.resize === indefinido) {p.resize = true;}
		if (p.drag) {
			. $ (Mh) css ('cursor', 'movimento');
			if ($. fn.jqDrag) {
				$ (Mw) jqDrag (mh).;
			} Else {
				try {
					. $ (Mw) arrastável ({punho:. $ ("#" + $ Jgrid.jqID (mh.id))});
				} Catch (e) {}
			}
		}
		if (p.resize) {
			if ($. fn.jqResize) {
				. $ (Mw) append ("<div class='jqResize ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se'> </ div>");
				$ ("#" + $ Jgrid.jqID (aIDs.themodal).) JqResize ("jqResize.", AIDs.scrollelm "#" + $ jgrid.jqID (aIDs.scrollelm):. False).;
			} Else {
				try {
					$ (Mw) redimensionável. ({Alças: 'SE, SW', alsoResize: aIDs.scrollelm "#" + $ jgrid.jqID (aIDs.scrollelm):. False});
				} Catch (r) {}
			}
		}
		if (p.closeOnEscape === true) {
			$ (MW). Keydown (function (e) {
				if (e.which == 27) {
					var. cone = $ (". #" + $ jgrid.jqID (aIDs.themodal)) dados ("OnClose") | | p.onClose;
					self.hideModal (. "#" + $ jgrid.jqID (aIDs.themodal), {gb: p.gbox, jqm: p.jqModal, OnClose: cone});
				}
			});
		}
	},
	viewModal: function (selector, o) {
		o = $. estender ({
			ToTop: true,
			sobreposição: 10,
			modal: false,
			overlayClass: 'ui-widget-overlay ",
			onShow:. $ jgrid.showModal,
			OnHide:. $ jgrid.closeModal,
			gbox:'',
			jqm: true,
			jqM: true
		}, O | | {});
		if ($. fn.jqm && o.jqm === true) {
			if (o.jqM) {$ (selector) attr ("hidden-ária", "false") jqm (o) jqmShow ();...}
			else {$ (selector) attr ("hidden-ária", "false") jqmShow ();..}
		} Else {
			if (o.gbox! =='') {
				. $ (". Jqgrid-overlay: em primeiro lugar", o.gbox) show ();
				$ (Selector) dados ("gbox", o.gbox).;
			}
			.. $ (Selector) show () attr ("hidden-ária", "false");
			try {$ (': Entrada: visível ", selector). [0] focus ();} catch (_) {}
		}
	},
	info_dialog: function (legenda, conteúdo c_b, modalopt) {
		var MOPT = {
			width: 290,
			height: 'auto',
			dataheight: 'auto',
			arrasto: true,
			redimensionar: false,
			esquerda: 250,
			top: 170,
			zIndex: 1000,
			jqModal: true,
			modal: false,
			closeOnEscape: true,
			align: 'center',
			buttonalign: "centro",
			botões: []
		/ / {Text: 'textbutt', id: "buttid", onClick: function () {...}}
		/ / Se o ID não é fornecido nós defini-lo como info_button_ + o índice na matriz - ou seja info_button_0, info_button_1 ...
		};
		. $ Estender (true, MOPT, $ jgrid.jqModal | | {}, {legenda: "<b>" caption + + "</ b>"}, modalopt | | {}.);
		var jm = mopt.jqModal, auto = this;
		if (fn.jqm && jm $!). {jm = false;}
		/ / Em caso de não haver jqModal
		var buttstr = "", i;
		if (mopt.buttons.length> 0) {
			for (i = 0; i <mopt.buttons.length; i + +) {
				if (mopt.buttons [i] ID === indefinido.) {mopt.buttons [i] id = "info_button_" + i;.}
				buttstr + = "<a id='"+mopt.buttons[i].id+"' class='fm-button ui-state-default ui-corner-all'>" + mopt.buttons [i]. texto + " </ a> ";
			}
		}
		var dh = isNaN (mopt.dataheight)? mopt.dataheight: mopt.dataheight + "px",
		cn = "text-align:" + mopt.align + ",";
		var cnt = "<div id='info_id'>";
		cnt + = "<div id = 'infocnt' style='margin:0px;padding-bottom:1em;width:100%;overflow:auto;position:relative;height:"+dh+";"+cn+"'>"+content+"</div>";
		cnt + = c_b? "<Div class = estilo 'ui-widget-content ui-helper-clearfix' = 'text-align:" + mopt.buttonalign + "; padding-bottom: 0.8em; padding-top: 0.5em; background-image: nenhum ; border-width: 1px 0 0 0; '> <a id='closedialog' class='fm-button ui-state-default ui-corner-all'> "+ c_b +" </ a> "+ buttstr +" < / div> ":
			buttstr! == ""? "<Div class = estilo 'ui-widget-content ui-helper-clearfix' = 'text-align:" + mopt.buttonalign + "; padding-bottom: 0.8em; padding-top: 0.5em; background-image: nenhum ; border-width: 1px 0 0 0;> "+ buttstr +" </ div> ":" ";
		cnt + = "</ div>";

		try {
			if ($ ("# info_dialog"). attr ("escondido aria-") === "false") {
				Jgrid.hideModal $ ("# info_dialog", {jqm: jm}).;
			}
			. $ ("# Info_dialog") remove ();
		} Catch (e) {}
		$. Jgrid.createModal ({
			themodal: 'info_dialog',
			modalhead: 'info_head',
			modalcontent: 'info_content',
			scrollelm: 'infocnt'},
			cnt,
			MOPT,
			'','', Verdadeiro
		);
		/ / Anexar onclick depois de inserir no DOM
		if (buttstr) {
			$. Cada (mopt.buttons, function (i) {
				$("#"+$.jgrid.jqID(this.id),"#info_id").bind('click',function(){mopt.buttons[i].onClick.call($("#info_dialog")); return false;});
			});
		}
		$ ("# CloseDialog", "# info_id"). Click (function () {
			self.hideModal ("# info_dialog", {
				jqm: jm,
				onClose:. $ ("# info_dialog") de dados ("onClose") | | mopt.onClose,
				gb:. $ ("# info_dialog") de dados ("gbox") | | mopt.gbox
			});
			return false;
		});
		$ ("Botão de fm.", "# Info_dialog"). Pairar (
			function () {$ (this) addClass ('ui-state-pairar');.}
			function () {$ (this) removeClass ('ui-state-pairar');.}
		);
		Se {mopt.beforeOpen ();} ($ isFunction (mopt.beforeOpen).)
		$. Jgrid.viewModal ("# info_dialog", {
			OnHide: function (h) {
				. hwhide () remove ();
				if (ho) {horemove ();}
			},
			modal: mopt.modal,
			jqm: jm
		});
		Se {mopt.afterOpen ();} ($ isFunction (mopt.afterOpen).)
		try {$ ("# info_dialog") focus ();.} catch (m) {}
	},
	bindEv: function (el, opt) {
		var $ t = this;
		if ($. isFunction (opt.dataInit)) {
			opt.dataInit.call ($ t, el, opt);
		}
		if () {opt.dataEvents
			$. Cada (opt.dataEvents, function () {
				if (this.data! == indefinido) {
					. $ (El) bind (this.type, this.data, this.fn);
				} Else {
					. $ (El) bind (this.type, this.fn);
				}
			});
		}
	},
Funções / / Formulário
	createEl: function (eltype, opções, vl, LARGURA, ajaxso) {
		var elem = "", $ t = this;
		setAttributes função (elm, atr, EXL) {
			var excluir = ['dataInit', 'dataEvents', 'DataURL', 'buildSelect', 'sopt', 'searchhidden', 'defaultValue', 'attr', 'custom_element', 'custom_value'];
			if (EXL! == indefinido && $. isArray (EXL)) {
				. $ Merge (excluir, EXL);
			}
			$. Cada (ATR, function (key, value) {
				if ($. inArray (key, excluir) === -1) {
					. $ (Olmo) attr (key, value);
				}
			});
			if (atr.hasOwnProperty! ('id')) {
				. $ (Olmo) attr ('id', $ jgrid.randId ().);
			}
		}
		switch (eltype)
		{
			case "textarea":
				elem = document.createElement ("textarea");
				if (LARGURA) {
					if (options.cols!) {$ (elem) css ({width: "98%"});.}
				} Else if (!) {Options.cols options.cols = 20;}
				se {options.rows = 2;} (options.rows!)
				if (vl === "" | | vl === "" | | (=== vl.length 1 && vl.charCodeAt (0) === 160)) {vl = "" ;}
				elem.value = vl;
				setAttributes (elem, opções);
				. $ (Elem) attr ({"papel": "caixa de texto", "várias linhas": "true"});
			break;
			caso "checkbox": / / o código para checkbox simples
				elem = document.createElement ("input");
				elem.type = "checkbox";
				if (options.value!) {
					. var VL1 = (vl + "") toLowerCase ();
					if (vl1.search (/ (false | f | 0 | nenhuma | n | off |! indefinido) / i) <0 && VL1 == "") {
						elem.checked = true;
						elem.defaultChecked = true;
						elem.value = vl;
					} Else {
						elem.value = "on";
					}
					. $ (Elem) attr ("offval", "off");
				} Else {
					var cbval = options.value.split (":");
					if (vl === cbval [0]) {
						elem.checked = true;
						elem.defaultChecked = true;
					}
					elem.value = cbval [0];
					. $ (Elem) attr ("offval", cbval [1]);
				}
				setAttributes (elem, opções, ['valor']);
				. $ (Elem) attr ("papel", "caixa");
			break;
			caso ", selecione":
				elem = document.createElement ("select");
				elem.setAttribute ("papel", "escolha");
				var do nível do mar, OVM = [];
				if (options.multiple === true) {
					MSL = true;
					elem.multiple = "múltiplo";
					. $ (Elem) attr ("aria-multiselectable", "true");
				} Else {MSL = false;}
				if (options.dataUrl! == indefinido) {
					var rowid = options.name? . String (options.id) substring (0, String (options.id) comprimento - String (options.name) Comprimento - 1..): String (options.id),
						postData = options.postData | | ajaxso.postData;

					if ($ tp && $ tpidPrefix) {
						. rowid = $ jgrid.stripPref ($ tpidPrefix, rowid);
					}
					$. Ajax ($. Estender ({
						url:. $ isFunction (options.dataUrl)? options.dataUrl.call ($ t, rowid, vl, String (options.name)): options.dataUrl,
						type: "GET",
						Tipo de dado: "html",
						dados:. $ isFunction (postData)? postData.call ($ t, rowid, vl, String (options.name)): postData,
						contexto: {elem: elem, opções: Opções, vl: vl},
						sucesso: function (data) {
							var ovm = [], elem = this.elem, vl = this.vl,
							options = $. extend ({}, this.options),
							MSL = options.multiple === verdade,
							a = $. isFunction (options.buildSelect)? options.buildSelect.call ($ t, dados): dados;
							if (typeof a === 'string') {
								. a = $ (. $ trim (a)) html ();
							}
							se (a) {
								. $ (Elem) anexar (a);
								setAttributes (elem, opções, postData ['postData']: indefinido);
								if (options.size === indefinido) {options.size = nível do mar? 3: 1;}
								if (MSL) {
									ovm = vl.split (",");
									. ovm = $ mapa (OVM, function (n) {. return $ trim (n);});
								} Else {
									. ovm [0] = $ trim (vl);
								}
								. / / $ (Elem) attr (opções);
								setTimeout (function () {
									$ ("Opção", elem). Cada (function (i) {
										/ / If (i === 0) {this.selected = "";}
										/ / Corrigir problema IE8/IE7 com a seleção do primeiro item em múltiplas = true
										if (i === 0 && elem.multiple) {this.selected = false;}
										. $ (This) attr ("opção" "papel");
										.. if ($ inArray ($ trim (esta $ () text ()), OVM)> -1 |. |... $ inArray ($ trim ($ (this) val ()), OVM)> -1 ) {
											this.selected = "selecionado";
										}
									});
								}, 0);
							}
						}
					}, Ajaxso | | {}));
				} Else if (options.value) {
					var i;
					if (options.size === indefinido) {
						options.size = nível do mar? 3: 1;
					}
					if (MSL) {
						ovm = vl.split (",");
						. ovm = $ mapa (OVM, function (n) {. return $ trim (n);});
					}
					if (typeof options.value === 'função') {options.value = options.value ();}
					var assim, sv, ov, 
					setembro = options.separator === indefinido? ":": Options.separator,
					delim = options.delimiter === indefinido? ";": Options.delimiter;
					if (typeof options.value === 'string') {
						so = options.value.split (delim);
						for (i = 0; i <so.length; i + +) {
							sv = assim [i] split (setembro).;
							if (sv.length> 2) {
								. sv [1] = $ map (sv, function (n, ii) {if (ii> 0) {return n;}}). join (setembro);
							}
							ov = document.createElement ("opção");
							ov.setAttribute ("opção" "papel");
							ov.value = sv [0]; ov.innerHTML = sv [1];
							elem.appendChild (ov);
							if (!. msl && ($ trim (sv [0]) === $ trim (vl) |. |.. $ trim (sv) [1] === $ trim (vl))) {ov.selected = "selecionada";}
							if (.. msl && ($ inArray ($ trim (sv) [1], OVM)> -1 | |. $ inArray ($ trim (sv [0]), OVM)> -1).) {ov. selected = "selected";}
						}
					} Else if (typeof options.value === 'objeto') {
						var OSV = options.value, chave;
						for (chave na OSV) {
							if (oSv.hasOwnProperty (chave)) {
								ov = document.createElement ("opção");
								ov.setAttribute ("opção" "papel");
								ov.value = chave; ov.innerHTML = OSV [key];
								elem.appendChild (ov);
								if (!. msl && ($ aparar (key) === $ trim (vl) |. |.. $ trim (OSV [key]) === $ trim (vl))) {ov.selected = "selecionado ";}
								if (.. msl && ($ inArray ($ trim (OSV [key]), OVM)> -1 | |.. $ inArray ($ trim (chave), OVM)> -1)) {ov.selected = " selecionado ";}
							}
						}
					}
					setAttributes (elem, opções, ['valor']);
				}
			break;
			caso "text":
			caso "password":
			case "botão":
				papel var;
				if (=== "botão" eltype) {role = "button";}
				else {role = "caixa de texto";}
				elem = document.createElement ("input");
				elem.type = eltype;
				elem.value = vl;
				setAttributes (elem, opções);
				if (eltype! == "botão") {
					if (LARGURA) {
						se {$ (elem) css ({width: "98%"}).;} (options.size!)
					} Else if {options.size = 20 (options.size!);}
				}
				. $ (Elem) attr ("papel", o papel);
			break;
			case "imagem":
			caso "file":
				elem = document.createElement ("input");
				elem.type = eltype;
				setAttributes (elem, opções);
				break;
			caso "custom":
				elem = document.createElement ("span");
				try {
					if ($. isFunction (options.custom_element)) {
						var CELM = options.custom_element.call ($ t, vl, opções);
						if (CELM) {
							. CELM = $ (CELM) addClass ("customelement") attr ({id: options.id, name: options.name}).;
							.. $ (Elem) empty () anexa (CELM);
						} Else {
							jogar "e2";
						}
					} Else {
						jogar "e1";
					}
				} Catch (e) {
					if (e === "e1") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_element '"+ $. jgrid.edit.msg.nodefined, $. jgrid.edit.bClose) ;}
					if (e === "e2") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_element '"+ $. jgrid.edit.msg.novalue, $. jgrid.edit.bClose) ;}
					else {$ jgrid.info_dialog ($ jgrid.errors.errcap, typeof e === "string" e:.?. e.Message, $ jgrid.edit.bClose);.}
				}
			break;
		}
		voltar elem;
	},
/ / Data de Validação Javascript
	checkdate: function (formato, data) {
		var daysInFebruary = function (ano) {
		/ / Fevereiro tem 29 dias em qualquer ano divisível por quatro,
		/ / EXCETO por anos centurial que não são também divisível por 400.
			(? ((Ano% 4 === 0) && (ano% 100 == 0 | | (ano% 400 === 0))) 29: 28) de retorno;
		},
		colher de chá = {}, setembro;
		format = format.toLowerCase ();
		/ / Nós procurar /, -,. para o separador de data
		if (format.indexOf ("/")! == -1) {
			setembro = "/";
		} Else if (format.indexOf ("-") == -1) {
			setembro = "-";
		} Else if (format.indexOf (".")! == -1) {
			setembro = ".";
		} Else {
			setembro = "/";
		}
		format = format.split (setembro);
		date = date.split (setembro);
		if (! date.length == 3) {return false;}
		var j = -1, YIN, dln = -1, mi = -1, i;
		for (i = 0; i <format.length; i + +) {
			var dv = isNaN (data [i])? 0: parseInt (data [i], 10);
			colher de chá [formato [i]] = dv;
			YIN = formato [i];
			if (! yln.indexOf ("y") == -1) {j = i;}
			if (yln.indexOf ("m") == -1!) {mi = i;}
			if (yln.indexOf ("d") == -1!) {dln = i;}
		}
		if (formato [j] === "y" | | formato [j] === "aaaa") {
			YIN = 4;
		} Else if (formato [j] === "yy") {
			YIN = 2;
		} Else {
			YIN = -1;
		}
		var DaysInMonth = [0,31,29,31,30,31,30,31,31,30,31,30,31]
		strDate;
		if (j === -1) {
			return false;
		}
			strDate = colher de chá [formato [j]] toString ().;
			if (YIN === 2 && strDate.length === 1) {YIN = 1;}
			if (strDate.length == YIN | |! (chá [formato [j]] === 0 && data [j] == "00")) {
				return false;
			}
		if (milhões === -1) {
			return false;
		}
			strDate = colher de chá [formato [milhões]] toString ().;
			if (strDate.length <1 | | colher de chá [formato [milhões]] <1 | | colher de chá [formato [milhões]]> 12) {
				return false;
			}
		if (DLN === -1) {
			return false;
		}
			strDate = colher de chá [formato [dln]] toString ().;
			if (strDate.length <1 | | colher de chá [formato [dln]] <1 | | colher de chá [formato [dln]]> 31 | | (chá [formato [milhões]] === 2 && colher de chá [formato [dln] ]> daysInFebruary (chá [formato [j]])) | | colher de chá [formato [dln]]> DaysInMonth [colher de chá [formato [milhões]]]) {
				return false;
			}
		return true;
	},
	isEmpty: function (val)
	{
		if (val.match (/ ^ \ s + $ /) | | val === "") {
			return true;
		}
			return false;
	},
	checkTime: function (tempo) {
	/ / verifica apenas hh: ss (e opcional am / pm)
		var re = / ^ (\ d {1,2}): (\ d {2}) ([APAP] [mm]) $ /, regs;
		if (! $. jgrid.isEmpty (tempo))
		{
			regs = time.match (re);
			if (regs) {
				if (regs [3]) {
					if (registros [1] <1 | | registros [1]> 12) {return false;}
				} Else {
					if (registros [1]> 23) {return false;}
				}
				if (regs [2]> 59) {
					return false;
				}
			} Else {
				return false;
			}
		}
		return true;
	},
	checkValues: function (val, valref, CustomObject, nam) {
		var edtrul, i, nm, dft, len, g = isso, cm = gpcolModel;
		if (CustomObject === indefinido) {
			if (typeof valref === 'string') {
				for (i = 0, len = cm.length; i <len; i + +) {
					if (cm [i]. === valref nome) {
						edtrul = cm [i] editrules.;
						valref = i;
						if (cm [i] = formoptions nulos.!) {nm = cm [i] formoptions.label;.}
						break;
					}
				}
			} Else if (valref> = 0) {
				edtrul = cm [valref] editrules.;
			}
		} Else {
			edtrul = CustomObject;
			nm = nam === indefinido? "_": Nam;
		}
		if (edtrul) {
			if (! nm) {nm = gpcolNames! = null? . gpcolNames [valref]: label cm [valref];}
			if (edtrul.required === true) {
				se {return [falso, nm + ":" + $ jgrid.edit.msg.required ",".];} ($ jgrid.isEmpty (val).)
			}
			/ / Força necessária
			var rqfield = edtrul.required === false? false: true;
			if (edtrul.number === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
					if (isNaN (val)) {return [falso, nm + ":" + $ jgrid.edit.msg.number ",".];}
				}
			}
			if (edtrul.minValue! == indefinido &&! isNaN (edtrul.minValue)) {
				if (parseFloat (val) <parseFloat (edtrul.minValue)) {return [falso, nm + ":". + $ jgrid.edit.msg.minValue + "" + edtrul.minValue, ""];}
			}
			if (edtrul.maxValue! == indefinido &&! isNaN (edtrul.maxValue)) {
				if (parseFloat (val)> parseFloat (edtrul.maxValue)) {return [falso, nm + ":" + $ jgrid.edit.msg.maxValue + "" + edtrul.maxValue ",".];}
			}
			filtro var;
			if (edtrul.email === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
				/ / Retirado $ Validar plug-in
					filter = /^((([az]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([az]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([az]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([az]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([az]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([az]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([az]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([az]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([az]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([az]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
					se {return [falso, nm + ":" + $ jgrid.edit.msg.email ",".];} (filter.test (val)!)
				}
			}
			if (edtrul.integer === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
					if (isNaN (val)) {return [falso, nm + ":" + $ jgrid.edit.msg.integer ",".];}
					if ((val% 1 == 0) | | (val.indexOf () == -1)! '.'!) {return [falso, nm + ":" + $ jgrid.edit.msg.integer ". "];}
				}
			}
			if (edtrul.date === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
					if (cm [valref]. formatoptions && cm [valref]. formatoptions.newformat) {
						. DFT = cm [valref] formatoptions.newformat;
						if ($. jgrid.formatter.date.masks.hasOwnProperty (DFT)) {
							. dft = $ jgrid.formatter.date.masks [DFT];
						}
					} Else {
						. = DFT cm [valref] DATEFMT | | "Ymd";
					}
					se {return [falso, nm + ":" + $ jgrid.edit.msg.date + "-" + dft ",".];} ($ jgrid.checkDate (DFT, val)!).
				}
			}
			if (edtrul.time === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
					(!. $ jgrid.checkTime (val)) se {return [. falsa, nm + ":" + $ jgrid.edit.msg.date + "- hh: mm (am / pm)", ""];}
				}
			}
			if (edtrul.url === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
					filter = /^(((https?)|(ftp)):\/\/([\-\w]+\.)+\w{2,3}(\/[%\-\w]+(\.\w{2,})?)*(([\w\-\.\?\\\/+@`~=%!]*)(\.\w{2,})?)*\/?)/i;
					se {return [falso, nm + ":" + $ jgrid.edit.msg.url ",".];} (filter.test (val)!)
				}
			}
			if (edtrul.custom === true) {
				if (! (rqfield === false && $. jgrid.isEmpty (val))) {
					if ($. isFunction (edtrul.custom_func)) {
						var ret = edtrul.custom_func.call (g, val, nm, valref);
						return $. isArray (ret)? ret: [. falsa $ jgrid.edit.msg.customarray, ""];
					}
					voltar [. falsa, $ jgrid.edit.msg.customfcheck, ""];
				}
			}
		}
		voltar [true, "", ""];
	}
});
}) (JQuery);
/ *
 * JqFilter jQuery jqGrid addon filtro.
 * Copyright (c) 2011, Tony Tomov, tony@trirand.com
 * Dupla licenciado sob as licenças MIT e GPL
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * O trabalho é inspirado a partir deste Stefan Pirvu
 * Http://www.codeproject.com/KB/scripting/json-filtering.aspx
 *
 * O filtro usa entidades JSON para manter as regras de filtragem e grupos. Aqui é um exemplo de um filtro:

{"GroupOp": "E",
      "grupos": [ 
        {"GroupOp": "OR",
            "regras": [
                {"Campo": "Nome", "op": "eq", "dados": "Inglaterra"}, 
                {"Campo": "id", "op": "le", "data": "5"}
             ]
        } 
      ],
      "regras": [
        {"Campo": "Nome", "op": "eq", "dados": "Romania"}, 
        {"Campo": "id", "op": "le", "data": "1"}
      ]
}
* /
/ * Jshint eqeqeq: false, eqnull: true, desenvolvi: true * /
/ * JQuery globais * /

(Function ($) {
"Use strict";

$. Fn.jqFilter = function (arg) {
	if (typeof arg === 'string') {
		
		. var fn = $ fn.jqFilter [arg];
		if (fn!) {
			jogar ("jqFilter - Inexistência método:" + arg);
		}
		.. var args = $ MakeArray (argumentos) fatia (1);
		voltar fn.apply (este, args);
	}

	var p = $. estender (true, {
		filtro: null,
		Colunas: [],
		onChange: null,
		afterRedraw: null,
		checkValues: null,
		erro: false,
		Mensagem de erro: "",
		errorcheck: true,
		showQuery: true,
		sopt: null,
		ops: [],
		operandos: null,
		numopts: ['eq', 'ne', 'lt', 'le', 'gt', 'ge', 'nu', 'nn', 'no', 'ni'],
		stropts: ['eq', 'ne', 'pc', 'bi', 'ew', 'en', 'cn', 'nc', 'nu', 'nn', 'no', 'ni' ],
		strarr: ['texto', 'string', 'blob'],
		groupOps: [{op: "E", o texto: "e"}, {op: "OR", text: "OR"}],
		groupButton: true,
		ruleButtons: verdadeiro,
		direção: "ltr"
	}, $ Jgrid.filter, arg | | {}).;
	voltar this.each (function () {
		if (this.filter) {return;}
		this.p = p;
		/ / Filter de configuração no caso, se eles não está definido
		if (this.p.filter === null | | this.p.filter === indefinido) {
			this.p.filter = {
				groupOp:. this.p.groupOps [0] op,
				regras: [],
				grupos: []
			};
		}
		var i, len = this.p.columns.length, cl,
		Isie = / msie / i.test (navigator.userAgent) && window.opera!;

		/ / Traduzindo as opções
		. this.p.initFilter = $ estender (true, {}, this.p.filter);

		/ / Definir valores padrão para as colunas se eles não estão definidas
		Se {return;} (len!)
		for (i = 0; i <len; i + +) {
			cl = this.p.columns [i];
			if (cl.stype) {
				/ / Compatibilidade de rede
				cl.inputtype = cl.stype;
			} Else if (cl.inputtype!) {
				cl.inputtype = 'text';
			}
			if (cl.sorttype) {
				/ / Compatibilidade de rede
				cl.searchtype = cl.sorttype;
			} Else if (cl.searchtype!) {
				cl.searchtype = 'string';
			}
			if (cl.hidden === indefinido) {
				/ / JqGrid compatibilidade
				cl.hidden = false;
			}
			if (cl.label!) {
				cl.label = cl.name;
			}
			if (cl.index) {
				cl.name = cl.index;
			}
			if (cl.hasOwnProperty! ('searchOptions')) {
				cl.searchoptions = {};
			}
			if (cl.hasOwnProperty! ('searchrules')) {
				cl.searchrules = {};
			}

		}
		if (this.p.showQuery) {
			. $ (This) anexar ("<classe de tabela = 'conteúdo ui-widget-queryresult ui-widget" style = "display: block; max-width: 440px; margem: 0px none;' dir = '" + this.p . direção + "'> <tbody> <td class='query'> </ td> </ tr> </ tbody> </ table>");
		}
		var getGrid = function () {
			return $ [0] | | nulo ("#" + $ jgrid.jqID (p.id).);
		};
		/ *
		 * Realizar a verificação.
		 *
		* /
		var checkData = function (val, colModelItem) {
			var ret = [true, ""], $ t = getGrid ();
			if ($. isFunction (colModelItem.searchrules)) {
				ret = colModelItem.searchrules.call ($ t, val, colModelItem);
			} Else if ($. Jgrid && $. Jgrid.checkValues) {
				try {
					. ret = $ jgrid.checkValues.call ($ t, val, -1, colModelItem.searchrules, colModelItem.label);
				} Catch (e) {}
			}
			if (ret && ret.length && ret [0] === false) {
				p.error = ret [0]!;
				p.errmsg = ret [1];
			}
		};
		/ * Se mudar para comum
		randId = function () {
			voltar Math.floor (Math.random () * 10000) toString ().;
		};
		* /

		this.onchange = function () {
			/ / Limpar qualquer erro 
			this.p.error = false;
			this.p.errmsg = "";
			return $. isFunction (this.p.onChange)? this.p.onChange.call (este, this.p): false;
		};
		/ *
		 * Redesenhar o filtro a cada momento novo campo é adicionado / excluídos
		 * E no campo será alterado
		 * /
		this.reDraw = function () {
			. $ ("Table.group: em primeiro lugar", this) remove ();
			var t = this.createTableForGroup (p.filter, null);
			. $ (This) anexar (t);
			if ($. isFunction (this.p.afterRedraw)) {
				this.p.afterRedraw.call (isto, this.p);
			}
		};
		/ *
		 * Cria um agrupamento de dados para o filtro
		 * @ Param grupo - objeto
		 * @ Param parentgroup - objeto
		 * /
		this.createTableForGroup = function (grupo, parentgroup) {
			var que = isso, i;
			/ / Esta tabela irá conter todos os grupos (tabelas) e regras (linhas)
			mesa var = $ ("<table class='group ui-widget ui-widget-content' style='border:0px none;'> <tbody> </ tbody> </ table>"),
			/ / Cria mensagem de erro linha
			align = "left";
			if (this.p.direction === "RTL") {
				align = "right";
				table.attr ("dir", "RTL");
			}
			if (parentgroup === null) {
				table.append ("<tr class='error' style='display:none;'> <th colspan='5' class='ui-state-error' align='"+align+"'> </ th> </ tr> ");
			}

			var tr = $ ("<tr> </ tr>");
			table.append (tr);
			/ / Este cabeçalho irá realizar o tipo de operador de grupo e botões de ação em grupo para
			/ / Criar subgrupo "+ {}", criando regra "+" ou excluir o grupo "-"
			var dia = $ ("<th colspan='5' align='"+align+"'> </ th>");
			tr.append (th);

			if (this.p.ruleButtons === true) {
			/ / Suspensa para: escolher tipo de operador grupo
			var groupOpSelect = $ ("<selecione class='opsel'> </ select>");
			th.append (groupOpSelect);
			/ / Preencher suspensa com todas as operadoras do grupo posible: ou, e
			var str = "", selecionada;
			for (i = 0; i <p.groupOps.length; i + +) {
				selected = group.groupOp === that.p.groupOps [i]. op? "Selected = 'selecionados'": "";
				. str + = "<option value='"+that.p.groupOps[i].op+"'" + selected+">" + that.p.groupOps [i] texto + "</ option>";
			}

			groupOpSelect
			. Anexar (str)
			. Bind ("mudança", function () {
				group.groupOp = $ (groupOpSelect) val ().;
				that.onchange () / / sinais de que o filtro foi alterado
			});
			}
			/ / Botão para adicionar um novo subgrupo
			var inputAddSubgroup = "<span> </ span>";
			if (this.p.groupButton) {
				inputAddSubgroup = $ ("<input type='button' value='+ {}' title='Add subgroup' class='add-group'/>");
				inputAddSubgroup.bind ('click', function () {
					if (group.groups === indefinido) {
						group.groups = [];
					}

					group.groups.push ({
						groupOp:. p.groupOps [0] op,
						regras: [],
						grupos: []
					}); / / Adicionar um novo grupo

					that.reDraw () / / o html mudou, forçar redesenhar

					that.onchange () / / sinais de que o filtro foi alterado
					return false;
				});
			}
			th.append (inputAddSubgroup);
			if (this.p.ruleButtons === true) {
			/ / Botão para adicionar uma nova regra
			var inputAddRule = $ ("<input type='button' value='+' title='Add rule' class='add-rule ui-add'/>"), cm;
			inputAddRule.bind ('click', function () {
				/ / Se {grupo = {};} (grupo!)
				if (group.rules === indefinido) {
					group.rules = [];
				}
				for (i = 0; i <that.p.columns.length; i + +) {
				/ / Mas mostram = true campos só serchable e serchhidden
					var pesquisável = (that.p.columns [i]. === busca indefinido)? verdadeiros: that.p.columns [i] de busca,.
					escondido = (that.p.columns [i]. escondido === true),
					ignoreHiding = (. that.p.columns [i] searchoptions.searchhidden === true);
					if ((ignoreHiding && pesquisável) | |! (pesquisável && oculto)) {
						cm = that.p.columns [i];
						break;
					}
				}
				
				var opr;
				if (cm.searchoptions.sopt) {opr = cm.searchoptions.sopt;}
				else if (that.p.sopt) {opr = that.p.sopt;}
				else if ($ inArray (cm.searchtype, that.p.strarr) == -1.!) {OPR = that.p.stropts;}
				else {OPR = that.p.numopts;}

				group.rules.push ({
					campo: cm.name,
					op: opr [0],
					Dados: ""
				}); / / Adicionar uma nova regra

				that.reDraw () / / o html mudou, forçar redesenhar
				/ / Para o momento nenhuma mudança foi feita para a regra, de modo
				/ / Isto não vai acionar onchange evento
				return false;
			});
			th.append (inputAddRule);
			}

			/ / Botão para apagar o grupo
			if (parentgroup! == null) {/ / ignorar o primeiro grupo
				var inputDeleteGroup = $ ("<input type='button' value='-' title='Delete group' class='delete-group'/>");
				th.append (inputDeleteGroup);
				inputDeleteGroup.bind ('click', function () {
				/ / Remove grupo de pais
					for (i = 0; i <parentgroup.groups.length; i + +) {
						if (parentgroup.groups [i] === grupo) {
							parentgroup.groups.splice (i, 1);
							break;
						}
					}

					that.reDraw () / / o html mudou, forçar redesenhar

					that.onchange () / / sinais de que o filtro foi alterado
					return false;
				});
			}

			Linhas / / anexa subgrupo
			if (! == group.groups indefinido) {
				for (i = 0; i <group.groups.length; i + +) {
					var trHolderForSubgroup = $ ("<tr> </ tr>");
					table.append (trHolderForSubgroup);

					var tdFirstHolderForSubgroup = $ ("<td class='first'> </ td>");
					trHolderForSubgroup.append (tdFirstHolderForSubgroup);

					var tdMainHolderForSubgroup = $ ("<td colspan='4'> </ td>");
					tdMainHolderForSubgroup.append (this.createTableForGroup (group.groups [i], grupo));
					trHolderForSubgroup.append (tdMainHolderForSubgroup);
				}
			}
			if (group.groupOp === indefinido) {
				group.groupOp = that.p.groupOps [0] op.;
			}

			/ / Anexa governa linhas
			if (! == group.rules indefinido) {
				for (i = 0; i <group.rules.length; i + +) {
					table.append (
                       this.createTableRowForRule (group.rules [i], grupo)
					);
				}
			}

			mesa de retorno;
		};
		/ *
		 * Criar a regra de dados para o filtro
		 * /
		this.createTableRowForRule = function (regra, grupo) {
			/ / Salva entidade atual em uma variável para que pudesse
			/ / Ser referenciado em chamadas de métodos anônimos

			var que = isso, $ t = getGrid (), tr = $ ("<tr> </ tr>"),
			/ / Document.createElement ("tr"),

			/ / Primeira coluna usada para preenchimento
			/ / TdFirstHolderForRule = document.createElement ("td"),
			i, op, trpar, cm, str = "", selecionada;
			/ / TdFirstHolderForRule.setAttribute ("class", "primeiro");
			tr.append ("<td class='first'> </ td>");


			/ / Cria o recipiente campo
			var ruleFieldTd = $ ("<td class='columns'> </ td>");
			tr.append (ruleFieldTd);


			/ / Suspensa para: campo escolher
			var ruleFieldSelect = $ ("<select> </ select>"), ina, aoprs = [];
			ruleFieldTd.append (ruleFieldSelect);
			ruleFieldSelect.bind ("mudança", function () {
				. rule.field = $ (ruleFieldSelect) val ();

				trpar = $ (this) pais ("tr: em primeiro lugar").;
				for (i = 0; i <that.p.columns.length; i + +) {
					if (that.p.columns [i]. === rule.field nome) {
						cm = that.p.columns [i];
						break;
					}
				}
				if (cm!) {return;}
				. cm.searchoptions.id = $ jgrid.randId ();
				if (Isie && cm.inputtype === "text") {
					if (cm.searchoptions.size!) {
						cm.searchoptions.size = 10;
					}
				}
				. var elm = $ jgrid.createEl.call ($ t, cm.inputtype, cm.searchoptions, "", true, that.p.ajaxSelectOptions | | {}, true);
				$ (Olmo) addClass ("input-elm").;
				/ / That.createElement (regra geral, "");

				if (cm.searchoptions.sopt) {op = cm.searchoptions.sopt;}
				else if (that.p.sopt) {op = that.p.sopt;}
				else if ($ inArray (cm.searchtype, that.p.strarr) == -1.!) {op = that.p.stropts;}
				else {op = that.p.numopts;}
				/ / operadores
				var s = "", so = 0;
				aoprs = [];
				. $ Cada (that.p.ops, function () {aoprs.push (this.oper);});
				for (i = 0; i <op.length; i + +) {
					ina = $ inArray (op [i], aoprs).;
					if (ina! == -1) {
						if (tão === 0) {
							rule.op = that.p.ops [ina] oper.;
						}
						. s + = "" + <option value='"+that.p.ops[ina].oper+"'> that.p.ops [ina] texto + "</ option>";
						portanto + +;
					}
				}
				.. $ (". Selectopts", trpar) empty () anexa (s);
				$ ("Selectopts.", Trpar) [0] = 0 selectedIndex.;
				if ($. jgrid.msie && $. jgrid.msiever () <9) {
					var sw = parseInt ($ ("select.selectopts", trpar) [0] offsetWidth, 10.) + 1;
					. $ (". Selectopts", trpar) largura (sw);
					. $ (". Selectopts", trpar) css ("largura", "auto");
				}
				/ / Dados
				.. $ (". Dados", trpar) empty () anexa (olmo);
				$ Jgrid.bindEv.call ($ t, olmo, cm.searchoptions).;
				$ (". Input-elm", trpar). Bind ("mudança", function (e) {
					var tmo = $ (this). hasClass ("ui-autocomplete-input")? 200: 0;
					setTimeout (function () {
						var elem = e.target;
						rule.data = elem.nodeName.toUpperCase () === "SPAN" && cm.searchoptions && $. isFunction (cm.searchoptions.custom_value)?
							cm.searchoptions.custom_value.call ($ t, $ (elem) crianças (:), 'get'. "customelement primeiro."): elem.value;
						that.onchange () / / sinais de que o filtro foi alterado
					}, Tmo);
				});
				setTimeout (function () {/ / IE, Opera, Chrome
				. rule.data = $ (olmo) val ();
				that.onchange () / / sinais de que o filtro foi alterado
				}, 0);
			});

			/ / Preencher suspensa com definições de coluna fornecidas pelo usuário
			var j = 0;
			for (i = 0; i <that.p.columns.length; i + +) {
				/ / Mas mostram = true campos só serchable e serchhidden
				var pesquisável = (that.p.columns [i]. === busca indefinido)? verdadeiros: that.p.columns [i] de busca,.
				escondido = (that.p.columns [i]. escondido === true),
				ignoreHiding = (. that.p.columns [i] searchoptions.searchhidden === true);
				if ((ignoreHiding && pesquisável) | |! (pesquisável && oculto)) {
					seleccionado = "";
					if (rule.field === that.p.columns [i]. nome) {
						selected = "selected = 'selecionados'";
						j = i;
					}
					str + = "<OPTION value='"+that.p.columns[i].name+"'" +selected+">" + that.p.columns [i] rótulo + "</ option>".;
				}
			}
			ruleFieldSelect.append (str);


			/ / Cria o recipiente operador
			var ruleOperatorTd = $ ("<td class='operators'> </ td>");
			tr.append (ruleOperatorTd);
			cm = p.columns [j];
			/ / Cria-lo aqui para que possa ser referentiated no evento onchange
			/ / Var RD = that.createElement (regra, rule.data);
			. cm.searchoptions.id = $ jgrid.randId ();
			if (Isie && cm.inputtype === "text") {
				if (cm.searchoptions.size!) {
					cm.searchoptions.size = 10;
				}
			}
			. var ruleDataInput = $ jgrid.createEl.call ($ t, cm.inputtype, cm.searchoptions, rule.data, é verdade, that.p.ajaxSelectOptions | | {}, true);
			if (rule.op === 'nu' | | rule.op === 'nn') {
				. $ (RuleDataInput) attr ('readonly', 'true');
				. $ (RuleDataInput) attr ('disabled', 'true');
			} / / Manter o estado dos campos de texto com deficiência em caso de ops nulos
			/ / Suspensa para: operador escolher
			var ruleOperatorSelect = $ ("<selecione class='selectopts'> </ select>");
			ruleOperatorTd.append (ruleOperatorSelect);
			ruleOperatorSelect.bind ("mudança", function () {
				. rule.op = $ (ruleOperatorSelect) val ();
				trpar = $ (this) pais ("tr: em primeiro lugar").;
				var rd = $ (". input-elm", trpar) [0];
				if (rule.op === "nu" | | rule.op === "nn") {/ / desativar para o operador "é nulo" e "não é nulo"
					rule.data = "";
					if (rd.tagName.toUpperCase () == 'SELECT'!) rd.value = "";
					rd.setAttribute ("readonly", "true");
					rd.setAttribute ("desativado", "true");
				} Else {
					if (rd.tagName.toUpperCase () === 'SELECT') rule.data = rd.value;
					rd.removeAttribute ("readonly");
					rd.removeAttribute ("desativado");
				}

				that.onchange () / / sinais de que o filtro foi alterado
			});

			/ / Preencher suspensa com todos os operadores disponíveis
			if (cm.searchoptions.sopt) {op = cm.searchoptions.sopt;}
			else if (that.p.sopt) {op = that.p.sopt;}
			else if ($ inArray (cm.searchtype, that.p.strarr) == -1.!) {op = that.p.stropts;}
			else {op = that.p.numopts;}
			str = "";
			. $ Cada (that.p.ops, function () {aoprs.push (this.oper);});
			for (i = 0; i <op.length; i + +) {
				ina = $ inArray (op [i], aoprs).;
				if (ina! == -1) {
					selected = rule.op === that.p.ops [ina]. oper? "Selected = 'selecionados'": "";
					. str + = "" + <option value='"+that.p.ops[ina].oper+"'"+selected+"> that.p.ops [ina] texto + "</ option>";
				}
			}
			ruleOperatorSelect.append (str);
			/ / Cria o contêiner de dados
			var ruleDataTd = $ ("<td class='data'> </ td>");
			tr.append (ruleDataTd);

			/ / Caixa de texto para: dados
			/ / É criado anteriormente
			/ / RuleDataInput.setAttribute ("tipo", "text");
			ruleDataTd.append (ruleDataInput);
			. $ Jgrid.bindEv.call ($ t, ruleDataInput, cm.searchoptions);
			$ (RuleDataInput)
			. AddClass ("input-elm")
			. Bind ("mudança", function () {
				rule.data = cm.inputtype === 'custom'? cm.searchoptions.custom_value.call (. $ t, $ (this) filhos (". customelement: em primeiro lugar"), 'get'):. $ (this) val ();
				that.onchange () / / sinais de que o filtro foi alterado
			});

			/ / Cria o recipiente ação
			var ruleDeleteTd = $ ("<td> </ td>");
			tr.append (ruleDeleteTd);

			/ / Botão para criar: regra de exclusão
			if (this.p.ruleButtons === true) {
			var ruleDeleteInput = $ ("<input type='button' value='-' title='Delete rule' class='delete-rule ui-del'/>");
			ruleDeleteTd.append (ruleDeleteInput);
			. / / $ (RuleDeleteInput) html ("")... Altura (20) (30) Botão de largura ({ícones: {primária: "ui-icon-menos", text: false}});
			ruleDeleteInput.bind ('click', function () {
				/ / Remove regra do grupo
				for (i = 0; i <group.rules.length; i + +) {
					if (group.rules [i] === regra) {
						group.rules.splice (i, 1);
						break;
					}
				}

				that.reDraw () / / o html mudou, forçar redesenhar

				that.onchange () / / sinais de que o filtro foi alterado
				return false;
			});
			}
			voltar tr;
		};

		this.getStringForGroup = function (grupo) {
			var s = "(", índice;
			if (! == group.groups indefinido) {
				for (index = 0; índice <group.groups.length; índice + +) {
					if (s.length> 1) {
						+ s = "" + group.groupOp + "";
					}
					try {
						s + = this.getStringForGroup (group.groups [index]);
					} Catch (ex) {alert (por exemplo);}
				}
			}

			if (! == group.rules indefinido) {
				try {
					for (index = 0; índice <group.rules.length; índice + +) {
						if (s.length> 1) {
							+ s = "" + group.groupOp + "";
						}
						s + = this.getStringForRule (group.rules [index]);
					}
				} Catch (e) {alert (e);}
			}

			s + = ")";

			if (s === "()") {
				retornar "" / / ignorar os grupos que não têm regras
			}
			retornar s;
		};
		this.getStringForRule = function (regra) {
			var opUF = "", OPC = "", i, cm, ret, val,
			numtypes = ['int', 'integer', 'float', 'número', 'moeda'] / / jqGrid
			for (i = 0; i <this.p.ops.length; i + +) {
				if (this.p.ops [i]. opera === rule.op) {
					opUF = this.p.operands.hasOwnProperty (rule.op)? this.p.operands [rule.op]: "";
					OPC = this.p.ops [i] oper.;
					break;
				}
			}
			for (i = 0; i <this.p.columns.length; i + +) {
				if (this.p.columns [i]. === rule.field nome) {
					cm = this.p.columns [i];
					break;
				}
			}
			if (cm === indefinido) {return "";}
			val = rule.data;
			if (OPC === 'pc' | | 'bi' OPC ===) {val = val + "%";}
			if (OPC === 'ew' | | OPC === 'en') {val = "%" + val;}
			if (OPC === 'cn' | | 'nc' OPC ===) {val = "%" + val + "%";}
			if (OPC === 'em' | | OPC === 'ni') {val = "(" + val + ")";}
			if (p.errorcheck) {checkData (rule.data, cm);}
			if ($ inArray (cm.searchtype, numtypes) == -1 |.! | OPC === 'nn' | | OPC === 'nu') {ret = rule.field + "" + opUF + "" + val;}
			else {ret = rule.field + "" + opUF + "\" "+ val +" \ "";}
			voltar ret;
		};
		this.resetFilter = function () {
			. this.p.filter = $ estender (true, {}, this.p.initFilter);
			this.reDraw ();
			this.onchange ();
		};
		this.hideError = function () {
			. $ ("Th.ui-estado-erro", this) html ("");
			. $ ("Tr.error", this) hide ();
		};
		this.showError = function () {
			. $ ("Th.ui-estado-erro", this) html (this.p.errmsg);
			. $ ("Tr.error", this) show ();
		};
		this.toUserFriendlyString = function () {
			retornar this.getStringForGroup (p.filter);
		};
		this.toString = function () {
			/ / Isto irá obter uma seqüência que pode ser usado para combinar um item.
			var que = this;
			função getStringRule (regra) {
				if (that.p.errorcheck) {
					var i, cm;
					for (i = 0; i <that.p.columns.length; i + +) {
						if (that.p.columns [i]. === rule.field nome) {
							cm = that.p.columns [i];
							break;
						}
					}
					if (cm) {checkData (rule.data, cm);}
				}
				voltar rule.op + "(item." + rule.field + ", '" + rule.data + "')";
			}

			função getStringForGroup (grupo) {
				var s = "(", índice;

				if (! == group.groups indefinido) {
					for (index = 0; índice <group.groups.length; índice + +) {
						if (s.length> 1) {
							if (group.groupOp === "OR") {
								s + = "| |";
							}
							else {
								+ s = "&&";
							}
						}
						s + = getStringForGroup (group.groups [index]);
					}
				}

				if (! == group.rules indefinido) {
					for (index = 0; índice <group.rules.length; índice + +) {
						if (s.length> 1) {
							if (group.groupOp === "OR") {
								s + = "| |";
							}
							else {
								+ s = "&&";
							}
						}
						s + = getStringRule (group.rules [index]);
					}
				}

				s + = ")";

				if (s === "()") {
					retornar "" / / ignorar os grupos que não têm regras
				}
				retornar s;
			}

			retornar getStringForGroup (this.p.filter);
		};

		/ / Aqui inicializar o filtro
		this.reDraw ();

		if (this.p.showQuery) {
			this.onchange ();
		}
		/ / Marca é como criado de modo que não será criado por duas vezes sobre este elemento
		this.filter = true;
	});
};
$. Estender ($. Fn.jqFilter, {
	/ *
	 * SQL retorno como string. Pode ser usado diretamente
	 * /
	ToSqlString: function ()
	{
		var s = "";
		this.each (function () {
			s = this.toUserFriendlyString ();
		});
		retornar s;
	},
	/ *
	 * Dados do filtro de retorno como objeto.
	 * /
	FilterData: function ()
	{
		var s;
		this.each (function () {
			s = this.p.filter;
		});
		retornar s;

	},
	getParameter: function (param) {
		if (param! == indefinido) {
			if (this.p.hasOwnProperty (param)) {
				voltar this.p [param];
			}
		}
		voltar this.p;
	},
	resetFilter: function () {
		voltar this.each (function () {
			this.resetFilter ();
		});
	},
	addFilter: function (PFilter) {
		if (typeof PFilter === "string") {
			PFilter = $ jgrid.parse (PFilter).;
	}
		this.each (function () {
			this.p.filter = PFilter;
			this.reDraw ();
			this.onchange ();
		});
	}

});
}) (JQuery);
/ * Jshint eqeqeq: false, eqnull: true, desenvolvi: true * /
/ * XmlJsonClass global, jQuery * /
(Function ($) {
/ **
 * JqGrid extensão para o formulário de edição de grade de dados
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
** /
"Use strict";
var rp_ge = {};
$. Jgrid.extend ({
	searchGrid: function (p) {
		p = $. estender (true, {
			recreateFilter: false,
			arrasto: true,
			sField: 'searchfield',
			sValue: 'searchString',
			Soper: 'searchOper',
			sFilter: "filtros",
			loadDefaults: true, / / ​​esta opção ativa o carregamento de filtros padrão de postData grade por apenas multipe Search.
			beforeShowSearch: null,
			afterShowSearch: null,
			onInitializeSearch: null,
			afterRedraw: null,
			afterChange: null,
			closeAfterSearch: false,
			closeAfterReset: false,
			closeOnEscape: false,
			searchOnEnter: false,
			multipleSearch: false,
			multipleGroup: false,
			/ / CloneSearchRowOnAdd: true,
			top: 0,
			esquerda: 0,
			jqModal: true,
			modal: false,
			redimensionar: true,
			width: 450,
			height: 'auto',
			dataheight: 'auto',
			showQuery: false,
			errorcheck: true,
			sopt: null,
			stringResult: undefined,
			onClose: null,
			onSearch: null,
			onreset: null,
			ToTop: true,
			sobreposição: 30,
			Colunas: [],
			tmplNames: null,
			tmplFilters: null,
			tmplLabel: 'Template:',
			showOnLoad: false,
			camada: null,
			operandos: {"eq": "=", "ne": "<>", "lt": "<", "le": "<=", "gt": ">", "ge": " > = "," pc ":" COMO "," bn ":" Não é como "," in ":" IN "," ni ":" NOT IN "," ew ":" LIKE "," en ": "Não é como", "cn": "LIKE", "nc": "Não é como", "nu": "IS NULL", "nn": "IsNot NULL"}
		}, $ Jgrid.search, p | | {}).;
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid!) {return;}
			var fid = "fbox_" + $ TPID,
			showFrm = true,
			mustReload = true,
			IDs = {themodal: 'searchmod' + fid, modalhead: 'searchhd' + fid, modalcontent: 'searchcnt' + fid, scrollelm: fid},
			defaultFilters = $ tppostData [p.sFilter];
			if (typeof defaultFilters === "string") {
				defaultFilters = $ jgrid.parse (defaultFilters).;
			}
			if (p.recreateFilter === true) {
				$ ("#" + $ Jgrid.jqID (IDs.themodal).) Remove ().;
			}
			função showFilter (_filter) {
				showFrm = $ ($ t) triggerHandler ("jqGridFilterBeforeShow" [_filter]).;
				if (showFrm === indefinido) {
					showFrm = true;
				}
				if ($ showFrm &&. isFunction (p.beforeShowSearch)) {
					showFrm = p.beforeShowSearch.call ($ t, _filter);
				}
				if (showFrm) {
					Jgrid.viewModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gbox:... "# Gbox_" + $ jgrid.jqID (FID), jqm: p.jqModal, modal: p.modal, overlay: p.overlay, ToTop: p.toTop});
					. $ ($ T) triggerHandler ("jqGridFilterAfterShow" [_filter]);
					if ($. isFunction (p.afterShowSearch)) {
						p.afterShowSearch.call ($ t, _filter);
					}
				}
			}
			if ($ ("#" + $. jgrid.jqID (IDs.themodal)) [0]! == undefined) {
				showFilter ($ ("# fbox_" + $ jgrid.jqID (+ $ TPID)).);
			} Else {
				var fil = $ ("<div> <div id='"+fid+"' class='searchFilter' style='overflow:auto'> </ div> </ div>"). insertBefore ("# gview_" + $. jgrid.jqID ($ TPID)),
				align = "left", butleft = ""; 
				if ($ tpdirection === "RTL") {
					align = "right";
					butleft = "style =" text-align: left '";
					fil.attr ("dir", "RTL");
				}
				colunas var = $. estender ([], $ tpcolModel),
				bs = "<a id='"+fid+"_search' class='fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset'> <span class =" ui-icon ui-icon-pesquisa '> </ span> "+ p.Find +" </ a> ",
				BC = "<a id='"+fid+"_reset' class='fm-button ui-state-default ui-corner-all fm-button-icon-left ui-search'> <span class =" ui-icon ui-icon-arrowreturnthick-1-w '> </ span> "+ p.Reset +" </ a> ",
				bQ = "", tmpl = "", colnm, encontrado = false, bt, cmi = -1;
				if (p.showQuery) {
					bQ = "<a id='"+fid+"_query' class='fm-button ui-state-default ui-corner-all fm-button-icon-left'> <span class =" ui-icon ui-icon -comment '> </ span> Consulta </ ​​a> ";
				}
				if (p.columns.length!) {
					$. Cada (colunas, function (i, n) {
						if (n.label!) {
							n.label = $ tpcolNames [i];
						}
						/ / Encontra primeira coluna pesquisável e configurá-lo se não houver filtro padrão
						if (! encontrado) {
							var pesquisável = (n.search === indefinido)? verdadeiro: n.search,
							escondido = (n.hidden === true),
							ignoreHiding = (n.searchoptions && n.searchoptions.searchhidden === true);
							if ((ignoreHiding && pesquisável) | |! (pesquisável && oculto)) {
								encontrado = true;
								colnm = n.index | | n.name;
								cmi = i;
							}
						}
					});
				} Else {
					columns = p.columns;
					cmi = 0;
					colnm = colunas [0] índice | | colunas [0] nome..;
				}
				/ / Comportamento antigo
				if ((defaultFilters && colnm) | | p.multipleSearch === false) {
					var CMOP = "eq";
					se (IMC> = 0 && colunas [cmi]. searchOptions && colunas [cmi]. searchoptions.sopt) {
						. CMOP = colunas [cmi] searchoptions.sopt [0];
					} Else if (p.sopt && p.sopt.length) {
						CMOP = p.sopt [0];
					}
					defaultFilters = {groupOp: "E", as regras: [{campo: colnm, op: CMOP, os dados: ""}]};
				}
				found = false;
				if (p.tmplNames && p.tmplNames.length) {
					encontrado = true;
					tmpl = p.tmplLabel;
					tmpl + = "<selecione class='ui-template'>";
					tmpl + = "<option value='default'> padrão </ option>";
					$. Cada (p.tmplNames, function (i, n) {
						tmpl + = "value='"+i+"'> <option" + n + "</ option>";
					});
					tmpl + = "</ select>";
				}

				bt = "<table class='EditTable' style='border:0px none;margin-top:5px' id='"+fid+"_2'> <tbody> <td colspan='2'> <hr 'widget-conteúdo ui-' estilo class = = 'margin: 1px "/> </ td> </ tr> <td class='EditButton' style='text-align:"+align+"'>" + BC + tmpl + "</ td> <td class='EditButton' "+butleft+">" + BQ + Bs + "</ td> </ tr> </ tbody> </ table>";
				fid = $ jgrid.jqID (FID).;
				$ ("#" + FID). JqFilter ({
					colunas: colunas,
					filtro: p.loadDefaults? defaultFilters: null,
					showQuery: p.showQuery,
					errorcheck: p.errorcheck,
					sopt: p.sopt,
					groupButton: p.multipleGroup,
					ruleButtons: p.multipleSearch,
					afterRedraw: p.afterRedraw,
					ops: p.odata,
					operandos: p.operands,
					ajaxSelectOptions: $ tpajaxSelectOptions,
					groupOps: p.groupOps,
					onChange: function () {
						if (this.p.showQuery) {
							. $ ('. Consulta', this) html (this.toUserFriendlyString ());
						}
						if ($. isFunction (p.afterChange)) {
							p.afterChange.call ($ t, $ ("#" + FID), p);
						}
					},
					direção: $ tpdirection,
					id: $ TPID
				});
				fil.append (BT);
				if (encontrados && p.tmplFilters && p.tmplFilters.length) {
					$ (". Ui-modelo", fil). Bind ("mudança", function () {
						. var curtempl = $ (this) val ();
						if (curtempl === "default") {
							$ ("#" + FID) jqFilter ('addFilter', defaultFilters).;
						} Else {
							$ ("#" + Fid) jqFilter ('addFilter', p.tmplFilters [parselnt (curtempl, 10)]).;
						}
						return false;
					});
				}
				if (p.multipleGroup === true) {p.multipleSearch = true;}
				. $ ($ T) triggerHandler ("jqGridFilterInitialize" [$ ("#" + FID)]);
				if ($. isFunction (p.onInitializeSearch)) {
					p.onInitializeSearch.call ($ t, $ ("#" + FID));
				}
				p.gbox = "# gbox_" + fid;
				if (p.layer) {
					$. Jgrid.createModal (IDs, fil, p, "# gview_" + $. Jgrid.jqID ($ TPID), $ ("# gbox_" + $. Jgrid.jqID ($ TPID)) [0] ", # ". + $ jgrid.jqID (p.layer) {position:" relativa "});
				} Else {
					. $ Jgrid.createModal (IDs, fil, p, "# gview_" + $ jgrid.jqID ($ TPID), $ ("# gbox_" + $ jgrid.jqID ($ TPID)) [0]..);
				}
				if (p.searchOnEnter | | p.closeOnEscape) {
					$ ("#" + $. Jgrid.jqID (IDs.themodal)). Keydown (function (e) {
						var $ target = $ (e.target);
						if (p.searchOnEnter && e.which === 13 && / / 13 === $. ui.keyCode.ENTER
								! $ Target.hasClass ('add-group') &&! $ Target.hasClass ('add-regra ") &&
								! $ Target.hasClass ('delete-grupo ") &&! $ Target.hasClass (' delete-regra") &&
								(! $ Target.hasClass ("botão de fm") | |! $ Target.is ("[id = $ _query]"))) {
							.. $ ("#" + + Fid "_search") foco (), clique ();
							return false;
						}
						if (p.closeOnEscape && e.which === 27) {/ / 27 === $. ui.keyCode.ESCAPE
							... $ (. "#" + $ Jgrid.jqID (IDs.modalhead)) encontrar (". Ui-jqdialog-titlebar de perto") foco (), clique ();
							return false;
						}
					});
				}
				if (QB) {
					$ ("#" + + Fid "_query"). Bind ('click', function () {
						. $ (". Queryresult", fil) alternância ();
						return false;
					});
				}
				if (p.stringResult === indefinido) {
					/ / Para fornecer compatibilidade com versões anteriores, inferindo valor stringResult de multipleSearch
					p.stringResult = p.multipleSearch;
				}
				$ ("#" + + Fid "_search"). Bind ('click', function () {
					var fl = $ ("#" + FID),
					sdata = {}, res,
					filtros = fl.jqFilter ('FilterData');
					if (p.errorcheck) {
						. fl [0] hideError ();
						Se {fl.jqFilter ('ToSqlString');} (p.showQuery!)
						if (fl [0]. p.error) {
							. fl [0] showError ();
							return false;
						}
					}

					if (p.stringResult) {
						try {
							/ / XmlJsonClass ou JSON.stringify
							res = xmlJsonClass.toJson (filtros,'','', false);
						} Catch (e) {
							try {
								res = JSON.stringify (filtros);
							} Catch (e2) {}
						}
						if (typeof res === "string") {
							sdata [p.sFilter] = res;
							. $ Cada ([p.sField, p.sValue, p.sOper], function () {sdata [este] = "";});
						}
					} Else {
						if (p.multipleSearch) {
							sdata [p.sFilter] = filtros;
							. $ Cada ([p.sField, p.sValue, p.sOper], function () {sdata [este] = "";});
						} Else {
							. sdata [p.sField] = filters.rules [0] de campo;
							sdata [p.sValue] = filters.rules [0] de dados.;
							sData [p.sOper] = filters.rules [0] op.;
							sdata [p.sFilter] = "";
						}
					}
					$ Tpsearch = true;
					. $ Estender ($ tppostData, sdata);
					mustReload = $ ($ t) triggerHandler ("jqGridFilterSearch").;
					if (mustReload === indefinido) {
						mustReload = true;
					}
					if ($ mustReload &&. isFunction (p.onSearch)) {
						mustReload = p.onSearch.call ($ t, $ tpfilters);
					}
					if (mustReload! == false) {
						. $ ($ T) gatilho ("reloadGrid", [{page: 1}]);
					}
					if (p.closeAfterSearch) {
						$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID($tpid),jqm:p.jqModal,onClose: p.onClose});
					}
					return false;
				});
				$ ("#" + + Fid "_reset"). Bind ('click', function () {
					var sdata = {},
					fl = $ ("#" + FID);
					$ Tpsearch = false;
					if (p.multipleSearch === false) {
						sdata [p.sField] = sdata [p.sValue] = sdata [p.sOper] = "";
					} Else {
						sdata [p.sFilter] = "";
					}
					. fl [0] resetFilter ();
					if (encontrado) {
						$ (". Ui-modelo", fil) val ("default").;
					}
					. $ Estender ($ tppostData, sdata);
					mustReload = $ ($ t) triggerHandler ("jqGridFilterReset").;
					if (mustReload === indefinido) {
						mustReload = true;
					}
					if ($ mustReload &&. isFunction (p.onReset)) {
						mustReload = p.onReset.call ($ t);
					}
					if (mustReload! == false) {
						. $ ($ T) gatilho ("reloadGrid", [{page: 1}]);
					}
					if (p.closeAfterReset) {
						$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID($tpid),jqm:p.jqModal,onClose: p.onClose});
					}
					return false;
				});
				showFilter ($ ("#" + FID));
				$. ("Botão fm:.. Não (ui-state-desativado)", fil) pairar (
					function () {$ (this) addClass ('ui-state-pairar');.}
					function () {$ (this) removeClass ('ui-state-pairar');.}
				);
			}
		});
	},
	editGridRow: function (rowid, p) {
		p = $. estender (true, {
			top: 0,
			esquerda: 0,
			width: 300,
			datawidth: 'auto',
			height: 'auto',
			dataheight: 'auto',
			modal: false,
			sobreposição: 30,
			arrasto: true,
			redimensionar: true,
			url: null,
			mtype: "POST",
			clearAfterAdd: true,
			closeAfterEdit: false,
			reloadAfterSubmit: true,
			onInitializeForm: null,
			beforeInitData: null,
			beforeShowForm: null,
			afterShowForm: null,
			beforeSubmit: null,
			afterSubmit: null,
			onclickSubmit: null,
			afterComplete: null,
			onclickPgButtons: null,
			afterclickPgButtons: null,
			EditData: {},
			recreateForm: false,
			jqModal: true,
			closeOnEscape: false,
			addedrow: "em primeiro lugar",
			topinfo:'',
			bottominfo:'',
			saveicon: [],
			closeicon: [],
			savekey: [falso, 13],
			navkeys: [falso, 38,40],
			checkOnSubmit: false,
			checkOnUpdate: false,
			_savedData: {},
			processamento: false,
			onClose: null,
			ajaxEditOptions: {},
			serializeEditData: null,
			viewPagerButtons: verdadeiro,
			overlayClass: 'ui-widget-overlay "
		}, $ Jgrid.edit, p | | {}).;
		rp_ge [. $ (this) [0] p.id] = p;
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid | | rowid!) {return;}
			var gid = $ TPID,
			frmgr = "FrmGrid_" + GID, frmtborg = "TblGrid_" + GID, frmtb = "#" + $. jgrid.jqID (frmtborg), 
			IDs = {themodal: 'editmod' + GID, modalhead: 'edithd' + GID, modalcontent: 'editcnt' + GID, scrollelm: frmgr},
			onBeforeShow = $. isFunction (rp_ge [$ TPID]. beforeShowForm)? . rp_ge [$ TPID] beforeShowForm: false,
			onAfterShow = $. isFunction (rp_ge [$ TPID]. afterShowForm)? rp_ge [$ TPID] afterShowForm:. falsa,
			onBeforeInit = $. isFunction (rp_ge [$ TPID]. beforeInitData)? . rp_ge [$ TPID] beforeInitData: false,
			onInitializeForm = $. isFunction (rp_ge [$ TPID]. onInitializeForm)? rp_ge [$ TPID] onInitializeForm:. falsa,
			showFrm = true,
			maxCols = 1, maxRows = 0, postdata, diff, frmoper;
			. frmgr = $ jgrid.jqID (frmgr);
			if (rowid === "novo") {
				rowid = "_empty";
				frmoper = "add";
				p.caption = rp_ge [$ TPID] addCaption.;
			} Else {
				p.caption = rp_ge [$ TPID] editCaption.;
				frmoper = "Editar";
			}
			if (p.recreateForm === verdadeiro && $ ("#" + $. jgrid.jqID (IDs.themodal)) [0]! == undefined) {
				$ ("#" + $ Jgrid.jqID (IDs.themodal).) Remove ().;
			}
			var closeovrl = true;
			if (p.checkOnUpdate && p.jqModal &&! p.modal) {
				closeovrl = false;
			}
			funcionar getFormData () {
				$ (Frmtb + "> tbody> tr> td>. FormElement"). Cada (function () {
					var CELM = $ ("customelement.", this);
					if (celm.length) {
						. var elem = CELM [0], nm = $ (elem) attr ('name');
						$. Cada ($ tpcolModel, function () {
							if (this.name === nm && this.editoptions && $. isFunction (this.editoptions.custom_value)) {
								try {
									(. $ t, $ ("#" + $ jgrid.jqID (nm), frmtb), 'get') postdata [nm] = this.editoptions.custom_value.call;
									if (postdata [nm] === indefinido) {throw "e1";}
								} Catch (e) {
									if (e === "e1") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_value '"+ $. jgrid.edit.msg.novalue, $. jgrid.edit.bClose) ;}
									else {$ jgrid.info_dialog ($ jgrid.errors.errcap, e.Message, $ jgrid.edit.bClose..);.}
								}
								return true;
							}
						});
					} Else {
					switch (este $ (). chegar (0). type) {
						caso "checkbox":
							if (. $ (this) é (": checked")) {
								. postdata [this.name] = $ (this) val ();
							} Else {
								var OFV = $ (this) attr ("offval").;
								postdata [this.name] = OFV;
							}
						break;
						caso ", selecione-um":
							postdata [this.name] = $ ("opção: selecionado", this). val ();
						break;
						caso ", selecione-múltiplo":
							. postdata [this.name] = $ (this) val ();
							if (postdata [this.name]) {. postdata [this.name] = postdata [this.name] join (",");}
							else {postdata [this.name] = "";}
							var SelectedText = [];
							$ ("Opção: selecionado", this) cada um (.
								função (i, selecionado) {
									. SelectedText [i] = $ (selecionado) text ();
								}
							);
						break;
						caso "password":
						caso "text":
						case "textarea":
						case "botão":
							. postdata [this.name] = $ (this) val ();

						break;
					}
					if ($ tpautoencode) {postdata [this.name] = $ jgrid.htmlEncode (postdata [this.name]);.}
					}
				});
				return true;
			}
			createData função (ROWID, obj tb, maxcols) {
				var nm, hc, trdata, cnt = 0, tmp, dc, elc, retpos = [], ind = false,
				tdtmpl = "<td class='CaptionTD'> </ td> <td class='DataTD'> </ td>", tmpl = "", i / / * 2
				for (i = 1; i <= maxcols; i + +) {
					tmpl + = tdtmpl;
				}
				if (rowid! == '_empty') {
					ind = $ (obj) jqGrid ("getInd", rowid).;
				}
				$ (Obj.p.colModel). Cada (function (i) {
					nm = this.name;
					Campos / / ocultas são incluídas no formulário
					if (this.editrules && this.editrules.edithidden === true) {
						hc = false;
					} Else {
						hc = this.hidden === verdade? verdadeiro: false;
					}
					dc = hc? "Style =" display: none "": "";
					if (nm! == 'cb' && nm! == 'subgrid' && this.editable === verdadeiro && nm! == 'rn') {
						if (ind === false) {
							tmp = "";
						} Else {
							if (nm === obj.p.ExpandColumn && obj.p.treeGrid === true) {
								. tmp = $ ("td [role = 'gridcell']: eq (" + i + ")", obj.rows [ind]) text ();
							} Else {
								try {
									. tmp = $ unformat.call (obj, $ ("td [role = 'gridcell']: eq (" + i + ")", obj.rows [ind]) {RowId: rowid, colModel: esta}, i );
								} Catch (_) {
									tmp = (this.edittype && this.edittype === "textarea")? $ ("Td [role = 'gridcell']: eq (" + i + ")", obj.rows [ind]) text ():. $ ("Td [role = 'gridcell']: eq (" + i + . ")", obj.rows [ind]) html ();
								}
								if (tmp | | tmp === "" | | tmp === "" | | (tmp.length === 1 && tmp.charCodeAt (0) === 160)) { tmp ='';}
							}
						}
						. var opt = $ estender ({}, this.editoptions | | {}, {id: nm, name: nm}),
						. frmopt = $ estender ({}, {elmprefix:'', elmsuffix:'', rowabove: false, rowcontent:''}, this.formoptions | | {}),
						rp = parseInt (frmopt.rowpos, 10) | | cnt +1,
						cp = parseInt ((parseInt (frmopt.colpos, 10) | | 1) * 2,10);
						if (rowid === "_empty" && opt.defaultValue) {
							tmp = $. isFunction (opt.defaultValue)? opt.defaultValue.call ($ t): opt.defaultValue;
						}
						if (this.edittype!) {this.edittype = "text";}
						if ($ tpautoencode) {tmp = $ jgrid.htmlDecode (tmp);.}
						elc = | | {}));
						/ / If (tmp === "" && this.edittype == "checkbox") {(offval ") tmp = $ (ELC) attr.";}
						/ / If (tmp === "" && this.edittype == "select") {tmp = $. ("Opção: eq (0)", elc) text ();}
						if (rp_ge [$ TPID] checkOnSubmit | | rp_ge [$ TPID] checkOnUpdate..) {rp_ge [$ TPID] _savedData [nm] = tmp;.}
						$ (ELC) addClass ("FormElement").;
						if ($. inArray (this.edittype, ['texto', 'textarea', 'senha', 'selecionar'])> -1) {
							. $ (ELC) addClass ("ui-widget-content ui-corner-all");
						}
						trdata = $ (tb) find ("tr [rowpos =" + rp + "]").;
						if (frmopt.rowabove) {
							var newdata = $ ("<td class='contentinfo' colspan='"+(maxcols*2)+"'>" + frmopt.rowcontent + "</ td> </ tr>");
							. $ (Tb) append (newdata);
							newdata [0] = rp rp.;
						}
						if (trdata.length === 0) {
							trdata = $ ("<tr "+dc+" rowpos='"+rp+"'> </ tr>") addClass ("FormData") attr ("id", "tr_" + nm)..;
							. $ (Trdata) append (tmpl);
							. $ (Tb) append (trdata);
							trdata [0] = rp rp.;
						}
						. (? Frmopt.label === indefinido obj.p.colNames [i]: frmopt.label): $ ("td eq (" + (CP-2) + ")", trdata [0]) html;
						. $ ("Td: eq (" + (CP-1) + ")", trdata [0]) append (frmopt.elmprefix) append (ELC) append (frmopt.elmsuffix);..
						if (this.edittype === 'custom' && $. isFunction (opt.custom_value)) {
							opt.custom_value.call ($ t, $ ("#" + nm, "#" + frmgr), "conjunto", tmp);
						}
						$ Jgrid.bindEv.call ($ t, elc, opt).;
						retpos [CNT] = i;
						cnt + +;
					}
				});
				if (cnt> 0) {
					var idrow = $ ("<tr class='FormData' style='display:none'> <td class='CaptionTD'> </ td> <td colspan = '" + (maxcols * 2-1) + "' class = "DataTD> <input class='FormElement' id='id_g' type='text' name='"+obj.p.id+"_id' value='"+rowid+"'/> </ td> </ tr> ");
					. idrow [0] = cnt rp 999;
					. $ (Tb) append (idrow);
					if (rp_ge [$ TPID] checkOnSubmit | | rp_ge [$ TPID] checkOnUpdate..) {rp_ge [$ TPID] _savedData [obj.p.id + "_id"] = rowid;.}
				}
				voltar retpos;
			}
			funcionar fillData (rowid, obj, FMID) {
				var nm, cnt = 0, tmp, fld, optar, vl, vlc;
				if (rp_ge [$ TPID] checkOnSubmit | | rp_ge [$ TPID] checkOnUpdate..) {rp_ge [$ TPID] _savedData = {};.. rp_ge [$ TPID] _savedData [obj.p.id + "_id"] = rowid ;}
				var cm = obj.p.colModel;
				if (rowid === '_empty') {
					$ (Cm). Cada (function () {
						nm = this.name;
						. opt = $ estender ({}, this.editoptions | | {});
						fld = $ (jgrid.jqID (nm), "#" + FMID "#" + $.);
						if (fld && fld.length && fld [0]! == null) {
							vl = "";
							if (this.edittype === 'custom' && $. isFunction (opt.custom_value)) {
								opt.custom_value.call ($ t, $ ("#" + nm, "#" + FMID), 'set', vl);
							} Else if (opt.defaultValue) {
								vl = $. isFunction (opt.defaultValue)? opt.defaultValue.call ($ t): opt.defaultValue;
								if (fld [0]. === tipo 'caixa') {
									vlc = vl.toLowerCase ();
									if (vlc.search (/ (false | f | 0 | nenhuma | n | off |! indefinido) / i) <0 && vlc == "") {
										. fld [0] verificado = true;
										. fld [0] defaultChecked = true;
										. fld [0] = valor vl;
									} Else {
										. fld [0] verificado = false;
										fld [0] defaultChecked = false.;
									}
								} Else {fld.val (vl);}
							} Else {
								if (fld [0]. === tipo 'caixa') {
									. fld [0] verificado = false;
									fld [0] defaultChecked = false.;
									vl = $ (FLD) attr ("offval").;
								} Else if (fld [0]. Digite && fld [0]. Type.substr (0,6) === 'selecionar') {
									fld [0] = 0 selectedIndex.;
								} Else {
									fld.val (vl);
								}
							}
							if (rp_ge [$ TPID] checkOnSubmit === verdadeiro | | rp_ge [$ TPID] checkOnUpdate. rp_ge.) {[$] TPID _savedData [nm] = vl;}.
						}
					});
					. $ ("# Id_g", "#" + FMID) val (rowid);
					retorno;
				}
				var tre = $ (obj) jqGrid ("getInd", rowid, true).;
				Se {return;} (tre!)
				$ ('Td [role = "gridcell"]', tre). Cada (function (i) {
					. nm = cm [i] nome;
					Campos / / ocultas são incluídas no formulário
					if (nm! == 'cb' && nm! == 'subgrid' && nm! == 'rn' && cm [i]. editável === true) {
						if (nm === obj.p.ExpandColumn && obj.p.treeGrid === true) {
							tmp = $ (this) text ().;
						} Else {
							try {
								. tmp = $ unformat.call (obj, $ (this) {RowId: rowid, colModel: cm [i]}, i);
							} Catch (_) {
								TMP = cm [i]. EditType === "textarea"? . $ (This) text ():. $ (This) html ();
							}
						}
						if ($ tpautoencode) {tmp = $ jgrid.htmlDecode (tmp);.}
						if (rp_ge [$ TPID] checkOnSubmit === verdadeiro | | rp_ge [$ TPID] checkOnUpdate..) {rp_ge [$ TPID] _savedData [nm] = tmp;.}
						. nm = $ jgrid.jqID (nm);
						switch (cm [i]. EditType) {
							caso "password":
							caso "text":
							case "botão":
							case "imagem":
							case "textarea":
								if (tmp === "" | | tmp === "" | | (tmp.length === 1 && tmp.charCodeAt (0) === 160)) {tmp ='' ;}
								$ ("#" + Nm, "#" + FMID) val (tmp).;
								break;
							caso ", selecione":
								var OPV = tmp.split (",");
								. OPV = $ mapa (OPV, function (n) {. return $ trim (n);});
								$ ("Opção" "#" + nm + "#" + FMID). Cada (function () {
									!... se (cm [i] editoptions.multiple && ($ trim (tmp) === $ trim (esta $ () text ()) |. |. OPV [0] === $ trim ($ ( . isso) text ()) | |.. OPV [0] === $ trim ($ (this) val ()))) {
										this.selected = true;
									} Else if (cm [i]. Editoptions.multiple) {
										.. if ($ inArray ($ trim (esta $ () text ()), VOP)> -1 |. |.. $ inArray ($ trim (esta $ () val ()), VOP)> -1. ) {
											this.selected = true;
										} Else {
											this.selected = false;
										}
									} Else {
										this.selected = false;
									}
								});
								break;
							caso "checkbox":
								tmp = String (tmp);
								if (cm [i]. editoptions && cm [i]. editoptions.value) {
									. var cb = cm [i] editoptions.value.split (":");
									if (cb [0] === tmp) {
										$ ("#" + Nm, "#" + FMID) [$ tpuseProp? 'Sustentar': 'attr'] ({"checked": true, "defaultChecked": true});
									} Else {
										$ ("#" + Nm, "#" + FMID) [$ tpuseProp? 'Sustentar': 'attr'] ({"checked": false, "defaultChecked": false});
									}
								} Else {
									tmp = tmp.toLowerCase ();
									if (tmp.search (/ (false | f | 0 | nenhuma | n | off |! indefinido) / i) <0 && tmp == "") {
										$ ("#" + Nm, "#" + FMID) [$ tpuseProp? 'Sustentar': 'attr'] ("checked", true);
										$ ("#" + Nm, "#" + FMID) [$ tpuseProp? 'Sustentar': 'attr'] ("defaultChecked", true) / / ie
									} Else {
										$ ("#" + Nm, "#" + FMID) [$ tpuseProp? 'Sustentar': 'attr'] ("checked", false);
										$ ("#" + Nm, "#" + FMID) [$ tpuseProp? 'Sustentar': 'attr'] ("defaultChecked", false) / / ie
									}
								}
								break;
							caso 'custom':
								try {
									if (cm [i]. editoptions && $. isFunction (cm [i]. editoptions.custom_value)) {
										. cm [i] editoptions.custom_value.call ($ t, $ ("#" + nm, "#" + FMID), "conjunto", tmp);
									} Else {throw "e1";}
								} Catch (e) {
									if (e === "e1") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_value '"+ $. jgrid.edit.msg.nodefined, $. jgrid.edit.bClose) ;}
									else {$ jgrid.info_dialog ($ jgrid.errors.errcap, e.Message, $ jgrid.edit.bClose..);.}
								}
								break;
						}
						cnt + +;
					}
				});
				if (cnt> 0) {$ ("# id_g", frmtb) val (rowid);.}
			}
			setNulls function () {
				$. Cada ($ tpcolModel, function (i, n) {
					if (n.editoptions && n.editoptions.NullIfEmpty === true) {
						if (postdata.hasOwnProperty (n.name) && postdata [n.name] === "") {
							postdata [n.name] = 'nulo';
						}
					}
				});
			}
			função de post-it () {
				var CopyData, ret = [true, "", ""], oncs = {}, opers = $ tpprmNames, idname, oper, chave, selr, i;
				
				. var retvals = $ ($ t) triggerHandler ("jqGridAddEditBeforeCheckValues", [$ ("#" + frmgr), frmoper]);
				if (retvals && retvals typeof === 'objeto') {postdata = retvals;}
				
				if ($. isFunction (rp_ge [$]. TPID beforeCheckValues)) {
					. retvals = rp_ge [$ TPID] beforeCheckValues.call ($ t, postdata, $ ("#" + frmgr), frmoper);
					if (retvals && retvals typeof === 'objeto') {postdata = retvals;}
				}
				for (chave na postdata) {
					if (postdata.hasOwnProperty (chave)) {
						. ret = $ jgrid.checkValues.call ($ t, postdata [key], chave);
						if (ret [0] === false) {break;}
					}
				}
				setNulls ();
				if (ret [0]) {
					. oncs = $ ($ t) triggerHandler ("jqGridAddEditClickSubmit" [rp_ge [$ TPID], postdata, frmoper]);
					if (oncs === indefinido && $. isFunction (rp_ge [$ TPID]. onclickSubmit)) { 
						. oncs = rp_ge [$ TPID] onclickSubmit.call ($ t, rp_ge [$ TPID], postdata, frmoper) | | {}; 
					}
					. ret = $ ($ t) triggerHandler ("jqGridAddEditBeforeSubmit" [postdata, $ ("#" + frmgr), frmoper]);
					if (ret === indefinido) {
						ret = [true, "", ""];
					}
					if (ret [0] && $. isFunction (rp_ge [$ TPID]. beforeSubmit)) {
						. ret = rp_ge [$ TPID] beforeSubmit.call ($ t, postdata, $ ("#" + frmgr), frmoper);
					}
				}

				if (ret [0] &&! rp_ge [$ TPID]. processamento) {
					. rp_ge [$ TPID] processamento = true;
					$ ("# SData", frmtb + "_2") addClass ('ui-state-activo »).;
					oper = opers.oper;
					idname = opers.id;
					/ / Somarmos a pos matriz de dados da ação - o nome é oper
					postdata [oper] = ($. trim (postdata [$ TPID + "_id"]) === "_empty")? opers.addoper: opers.editoper;
					if (postdata [oper]! == opers.addoper) {
						postdata [idname] = postdata [$ TPID + "_id"];
					} Else {
						/ / Verifica para ver se temos allredy este campo do formulário e se sim Lieve ele
						if (postdata [idname] === indefinido) {postdata [idname] = postdata [$ TPID + "_id"];}
					}
					excluir postdata [$ TPID + "_id"];
					. postdata = $ estender (postdata, rp_ge [$ TPID] EditData, oncs.);
					if ($ tptreeGrid === true) {
						if (postdata [oper] === opers.addoper) {
						selr = $ ($ t) jqGrid ("getGridParam", 'selrow').;
							var tr_par_id = $ tptreeGridModel === 'adjacência'? $ TptreeReader.parent_id_field: 'parent_ID';
							postdata [tr_par_id] = selr;
						}
						for (i in $ tptreeReader) {
							if ($ tptreeReader.hasOwnProperty (i)) {
								var itm = $ tptreeReader [i];
								if (postdata.hasOwnProperty (ITM)) {
									if (postdata [oper] === opers.addoper && i === 'parent_id_field') {continue;}
									postdata apagar [ITM];
								}
							}
						}
					}
					
					. postdata [idname] = $ jgrid.stripPref ($ tpidPrefix, postdata [idname]);
					var AjaxOptions = $. estender ({
						url:.. rp_ge [$ TPID] url | | $ ($ t) jqGrid ('getGridParam', 'editurl'),
						Tipo:. rp_ge [$ TPID] mtype,
						dados:. $ isFunction (rp_ge [$ TPID] serializeEditData.)? . rp_ge [$ TPID] serializeEditData.call ($ t, postdata): postdata,
						completar: function (dados, status) {
							chave var;
							postdata [idname] = $ tpidPrefix + postdata [idname];
							if (data.status> = 300 && data.status! == 304) {
								ret [0] = false;
								ret [1] = $ ($ t) triggerHandler ("jqGridAddEditErrorTextFormat" [dados, frmoper]).;
								if ($. isFunction (rp_ge [$ TPID]. errorTextFormat)) {
									. ret [1] = rp_ge [$ TPID] errorTextFormat.call $ (t, dados, frmoper);
								} Else {
									ret [1] = Estado + "Estado:" "" código de erro.: "+ data.statusText + '+ data.status;
								}
							} Else {
								/ / Os dados são postados sucesso
								/ / Executar aftersubmit com os dados retornados a partir de servidor
								. ret = $ ($ t) triggerHandler ("jqGridAddEditAfterSubmit" [dados, postdata, frmoper]);
								if (ret === indefinido) {
									ret = [true, "", ""];
								}
								if (ret [0] && $. isFunction (rp_ge [$ TPID]. afterSubmit)) {
									. ret = rp_ge [$ TPID] afterSubmit.call ($ t, dados, postdata, frmoper);
								}
							}
							if (ret [0] === false) {
								$ ("# FormError> td", frmtb) html (ret [1]).;
								. $ ("# FormError", frmtb) show ();
							} Else {
								if ($ tpautoencode) {
									$. Cada (postdata, function (n, v) {
										. postdata [n] = $ jgrid.htmlDecode (v);
									});
								}
								..! / / Rp_ge [$ TPID] reloadAfterSubmit = rp_ge [$ TPID] reloadAfterSubmit && $ tpdatatype = "local";
								/ / A ação é adicionar
								if (postdata [oper] === opers.addoper) {
									/ / Processamento id
									/ / Usuário não definir o ret id [2]
									if (ret [2]!) {ret [2] = $ jgrid.randId (),.}
									postData [idname] = ret [2];
									if (rp_ge [$ TPID]. reloadAfterSubmit) {
										. $ ($ T) gatilho ("reloadGrid");
									} Else {
										if ($ tptreeGrid === true) {
											$ ($ T) jqGrid ("addChildNode", ret [2], selr, postdata).;
										} Else {
											$ ($ T) jqGrid ("addRowData", ret [2], postdata, p.addedrow).;
										}
									}
									if (rp_ge [$ TPID]. closeAfterAdd) {
										if ($ tptreeGrid! == true) {
											$ ($ T) jqGrid ("setSelection", ret [2]).;
										}
										$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID(gID),jqm:p.jqModal,onClose: rp_ge [$ TPID] onClose}).;
									} Else if (rp_ge [$ TPID]. ClearAfterAdd) {
										fillData ("_empty", $ t, frmgr);
									}
								} Else {
									/ / A ação é atualizar
									if (rp_ge [$ TPID]. reloadAfterSubmit) {
										. $ ($ T) gatilho ("reloadGrid");
										Se {setTimeout (function () {$ ($ t) jqGrid ("setSelection", postdata [idname]).;}, 1000);} (rp_ge [$ TPID] closeAfterEdit!).
									} Else {
										if ($ tptreeGrid === true) {
											. $ ($ T) jqGrid ("setTreeRow", postdata [idname], postdata);
										} Else {
											$ ($ T) jqGrid ("setRowData", postdata [idname], postdata).;
										}
									}
									if (rp_ge [$ TPID]. closeAfterEdit) rp_ge [$ TPID] onClose});.}
								}
								if ($. isFunction (rp_ge [$ TPID]. afterComplete)) {
									CopyData = dados;
									setTimeout (function () {
										. $ ($ T) triggerHandler ("jqGridAddEditAfterComplete" [CopyData, postdata, $ ("#" + frmgr), frmoper]);
										. rp_ge [$ TPID] afterComplete.call ($ t, CopyData, postdata, $ ("#" + frmgr), frmoper);
										CopyData = null;
									}, 500);
								}
								if (rp_ge [$ TPID] checkOnSubmit |. |. rp_ge [$ TPID] checkOnUpdate) {
									$ ("#" + Frmgr) de dados ("desativado", false).;
									if (rp_ge [$ TPID]. _savedData [$ TPID + "_id"]! == "_empty") {
										for (chave na rp_ge [$ TPID]. _savedData) {
											if (rp_ge [$ TPID]. _savedData.hasOwnProperty (key) && postdata [key]) {
												. rp_ge [$ TPID] _savedData [key] = postdata [key];
											}
										}
									}
								}
							}
							. rp_ge [$ TPID] processamento = false;
							$ ("# SData", frmtb + "_2") removeClass ('ui-state-activo »).;
							try {$ (': Entrada: visível "," # "+ frmgr). [0] se concentrar ();} catch (e) {}
						}
					}, $ Jgrid.ajaxOptions, rp_ge [$ TPID] ajaxEditOptions)..;

					if (! ajaxOptions.url &&! rp_ge [$ TPID]. useDataProxy) {
						if ($. isFunction ($ tpdataProxy)) {
							. rp_ge [$ TPID] useDataProxy = true;
						} Else {
							ret [0] = false; ret [1] + = "" + $ jgrid.errors.nourl.;
						}
					}
					if (ret [0]) {
						if (rp_ge [$ TPID]. useDataProxy) {
							var dpret = $ tpdataProxy.call ($ t, AjaxOptions ", Set_" + $ TPID); 
							if (dpret === indefinido) {
								dpret = [true, ""];
							}
							if (dpret [0] === false) {
								ret [0] = false;
								ret [1] = dpret [1] | |! "Erro ao excluir a linha selecionada" ;
							} Else {
								if (ajaxOptions.data.oper === opers.addoper && rp_ge [$ TPID]. closeAfterAdd) {
									Jgrid.hideModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gb:.. "# Gbox_" + $ jgrid.jqID (GID), jqm:. P.jqModal, OnClose: rp_ge [$ TPID ] onClose}).;
								}
								if (ajaxOptions.data.oper === opers.editoper && rp_ge [$ TPID]. closeAfterEdit) {
									Jgrid.hideModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gb:.. "# Gbox_" + $ jgrid.jqID (GID), jqm:. P.jqModal, OnClose: rp_ge [$ TPID ] onClose}).;
								}
							}
						} Else {
							. $ Ajax (AjaxOptions); 
						}
					}
				}
				if (ret [0] === false) {
					$ ("# FormError> td", frmtb) html (ret [1]).;
					. $ ("# FormError", frmtb) show ();
					/ / Retorno;
				}
			}
			funcionar CompareData (nObj, oObj) {
				var ret = false, chave;
				for (chave na nObj) {
					if (nObj.hasOwnProperty (key) && nObj [key]! = oObj [key]) {
						ret = true;
						break;
					}
				}
				voltar ret;
			}
			checkUpdates function () {
				var status = true;
				. $ ("# FormError", frmtb) hide ();
				if (rp_ge [$ TPID]. checkOnUpdate) {
					postdata = {};
					getFormData ();
					diff = CompareData (postdata, rp_ge [$ TPID] _savedData.);
					if (diff) {
						$ ("#" + Frmgr) dados ("deficientes", true).;
						. $ (". Confirmar", "#" + IDs.themodal) show ();
						status = false;
					}
				}
				retornar status;
			}
			restoreInline função ()
			{
				var i;
				if (rowid! == "_empty" && $ tpsavedRow! == indefinido && $ tpsavedRow.length> 0 && $. isFunction ($. fn.jqGrid.restoreRow)) {
					for (i = 0; i <$ tpsavedRow.length; i + +) {
						if ($ tpsavedRow [i]. id == rowid) {
							$ ($ T) jqGrid ('restoreRow ", rowid).;
							break;
						}
					}
				}
			}
			função updateNav (cr, posarr) {
				. var TOTR = posarr [1] Comprimento-1;
				if (cr === 0) {
					$ ("#", PData frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else if (posarr [1] [cr-1]! == Indefinido && $ ("#" + $. Jgrid.jqID (posarr [1] [cr-1])). HasClass ('ui-state-desativado ')) {
						$ ("#", PData frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else {
					. $ ("#", PData frmtb + "_2") removeClass ('ui-state-deficientes ");
				}
				
				if (cr === TOTR) {
					$ ("# NData", frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else if (posarr [1] [cr +1]! == Indefinido && $ ("#" + $. Jgrid.jqID (posarr [1] [cr +1])). HasClass ('ui-state-desativado ')) {
					$ ("# NData", frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else {
					. $ ("# NData", frmtb + "_2") removeClass ('ui-state-deficientes ");
				}
			}
			getCurrPos function () {
				var rowsInGrid = $ ($ t). jqGrid ("getDataIDs"),
				selrow = $ ("# id_g", frmtb). val (),
				pos = $ inArray (selrow, rowsInGrid).;
				voltar [pos, rowsInGrid];
			}

			if ($ ("#" + $. jgrid.jqID (IDs.themodal)) [0]! == undefined) {
				. showFrm = $ ($ t) triggerHandler ("jqGridAddEditBeforeInitData" [$ ("#" + $ jgrid.jqID (frmgr)), frmoper.]);
				if (showFrm === indefinido) {
					showFrm = true;
				}
				if (showFrm && onBeforeInit) {
					showFrm = onBeforeInit.call ($ t, $ ("#" + frmgr), frmoper);
				}
				if (showFrm === false) {return;}
				restoreInline ();
				$ (". Ui-jqdialog-título", "#" + $ jgrid.jqID (IDs.modalhead).) Html (p.caption).;
				. $ ("# FormError", frmtb) hide ();
				if (rp_ge [$ TPID]. topinfo) {
					. $ (". Topinfo", frmtb) html (rp_ge [$ TPID] topinfo.);
					$ (, Frmtb "tinfo.") Show ().;
				} Else {
					. $ (". Tinfo", frmtb) hide ();
				}
				if (rp_ge [$ TPID]. bottominfo) {
					. $ (". Bottominfo", frmtb + "_2") html (rp_ge [$ TPID] bottominfo.);
					. $ (". Binfo", frmtb + "_2") show ();
				} Else {
					. $ (". Binfo", frmtb + "_2") hide ();
				}
				/ / Filldata
				fillData (rowid, $ t, frmgr);
				/ / /
				if (rowid === "_empty" | |! rp_ge. [$] TPID viewPagerButtons) {
					. $ ("# # PData, nData", frmtb + "_2") hide ();
				} Else {
					. $ ("# PData, # nData", frmtb + "_2") show ();
				}
				if (rp_ge [$ TPID]. processamento === true) {
					. rp_ge [$ TPID] processamento = false;
					$ ("# SData", frmtb + "_2") removeClass ('ui-state-activo »).;
				}
				if ($ ("#" + frmgr). dados ("desativado") === true) {
					. $ (".. Confirmar", "#" + $ jgrid.jqID (IDs.themodal)) hide ();
					$ ("#" + Frmgr) de dados ("desativado", false).;
				}
				. $ ($ T) triggerHandler ("jqGridAddEditBeforeShowForm" [$ ("#" + frmgr), frmoper]);
				if (onBeforeShow) {onBeforeShow.call ($ t, $ ("#" + frmgr), frmoper);}
				$ Dados ("onClose", rp_ge [$ TPID] onClose.) ("#" + $ Jgrid.jqID (IDs.themodal).).;
				Jgrid.viewModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gbox:... "# Gbox_" + $ jgrid.jqID (GID), jqm: p.jqModal, jqM: false, overlay: p.overlay, modal: p.modal, overlayClass: p.overlayClass});
				if (closeovrl!) {
					$ ("." + $. Jgrid.jqID (p.overlayClass)). Click (function () {
						if (checkUpdates (!)) {return false;}
						Jgrid.hideModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gb:.. "# Gbox_" + $ jgrid.jqID (GID), jqm:. P.jqModal, OnClose: rp_ge [$ TPID ] onClose}).;
						return false;
					});
				}
				. $ ($ T) triggerHandler ("jqGridAddEditAfterShowForm" [$ ("#" + frmgr), frmoper]);
				if (onAfterShow) {onAfterShow.call ($ t, $ ("#" + frmgr), frmoper);}
			} Else {
				var dh = isNaN (p.dataheight)? p.dataheight: p.dataheight + "px",
				dw = isNaN (p.datawidth)? p.datawidth: p.datawidth + "px",
				frm = $ ("<nome do formulário = id 'FormPost' = '" + frmgr + "' class = 'formGrid' onSubmit = 'return false;" style='width:"+dw+";overflow:auto;position:relative;height:"+dh+";'></form>").data("disabled",false),
				tbl = $ ("<table id='"+frmtborg+"' class='EditTable' cellspacing='0' cellpadding='0' border='0'> <tbody> </ tbody> </ table>");
				. showFrm = $ ($ t) triggerHandler ("jqGridAddEditBeforeInitData" [$ ("#" + frmgr), frmoper]);
				if (showFrm === indefinido) {
					showFrm = true;
				}
				if (showFrm && onBeforeInit) {
					showFrm = onBeforeInit.call ($ t, $ ("#" + frmgr), frmoper);
				}
				if (showFrm === false) {return;}
				restoreInline ();
				$ ($ TpcolModel) cada (função. () {
					var fmto = this.formoptions;
					maxCols = Math.max (? maxCols, fmto fmto.colpos | | 0: 0);
					maxRows = Math.max (maxRows, fmto fmto.rowpos | | 0: 0);
				});
				. $ (FRM) append (TBL);
				var flr = $ ("<tr id='FormError' style='display:none'> <td class='ui-state-error' colspan='"+(maxCols*2)+"'> </ td> </ tr> ");
				flr [0] rp = 0.;
				. $ (TBL) append (flr);
				/ / Topinfo
				flr = $ ("<tr style='display:none' class='tinfo'> <td class='topinfo' colspan='"+(maxCols*2)+"'>" + rp_ge [$ TPID]. topinfo + "</ td> </ tr>");
				flr [0] rp = 0.;
				. $ (TBL) append (flr);
				/ / Definir o id.
				/ / Use cuidado só para mudar aqui colproperties.
				/ / Criar dados
				var rtlb = $ tpdirection === "RTL"? verdadeiro: false,
				bp = rtlb? "NDATA": "", pData
				BN = rtlb? "PData": "nData";
				createData (rowid, $ t, tbl, maxCols);
				/ / botões no rodapé
				var bP = "<a id='"+bp+"' class='fm-button ui-state-default ui-corner-left'> <span class =" ui-ui-ícone ícone de triângulo-1-w ' > </ span> </ a> ",
				BN = "<a id='"+bn+"' class='fm-button ui-state-default ui-corner-right'> <span class='ui-icon ui-icon-triangle-1-e'> </ span> </ a> ",
				bs = "<a id='sData' class='fm-button ui-state-default ui-corner-all'>" + p.bSubmit + "</ a>",
				BC = "<a id='cData' class='fm-button ui-state-default ui-corner-all'>" + p.bCancel + "</ a>";
				var bt = "<table border='0' cellspacing='0' cellpadding='0' class='EditTable' id='"+frmtborg+"_2'> <tbody> <td colspan='2'> <hr class='ui-widget-content' style='margin:1px'/> </ td> </ tr> <tr id='Act_Buttons'> <td class='navButton'> "+ (rtlb? bN + BP: bP + bi) + "</ td> <td class='EditButton'>" + bS + BC + "</ td> </ tr>";
				bt + = "<tr style='display:none' class='binfo'> <td class='bottominfo' colspan='2'>" + rp_ge [$ TPID]. bottominfo + "</ td> </ tr> ";
				bt + = "</ tbody> </ table>";
				if (maxRows> 0) {
					var sd = [];
					$. Cada ($ (TBL) [0]. Linhas, função (i, r) {
						sd [i] = r;
					});
					sd.sort (function (a, b) {
						if (a.rp> b.rp) {return 1;}
						if (a.rp <b.rp) {return 1;}
						return 0;
					});
					$. Cada (sd, função (index, linha) {
						. $ ('Tbody ", tbl) anexar (linha);
					});
				}
				. p.gbox = "# gbox_" + $ jgrid.jqID (GID);
				var cle = false;
				if (p.closeOnEscape === true) {
					p.closeOnEscape = false;
					cle = true;
				}
				.. var tms = $ ("<div> </ div>") append (FRM) anexar (BT);
				. $ Jgrid.createModal (IDs, tms, p, "# gview_" + $ jgrid.jqID ($ TPID), $ ("# gbox_" + $ jgrid.jqID ($ TPID)) [0]..);
				if (rtlb) {
					. $ ("# PData, # nData", frmtb + "_2") css ("flutuar", "direito");
					. $ (". EditButton", frmtb + "_2") css ("text-align", "esquerda");
				}
				if (rp_ge [$ TPID] topinfo.) {$ show () (, frmtb "tinfo.");.}
				if (. rp_ge [$ TPID] bottominfo) {. $ (". binfo", frmtb + "_2") show ();}
				TMS = null; bt = null;
				$ ("#" + $. Jgrid.jqID (IDs.themodal)). Keydown (function (e) {
					var WKEY = e.target;
					if (. frmgr $ ("#" +) de dados ("desativado") === true) {return false;} / /?
					if (rp_ge [$ TPID]. savekey [0] === verdadeiro && e.which === rp_ge [$ TPID]. savekey [1]) {/ / salvar
						if (wkey.tagName! == "TEXTAREA") {
							. $ ("# SData", frmtb + "_2") gatilho ("click");
							return false;
						}
					}
					if (e.which === 27) {
						if (checkUpdates (!)) {return false;}
						. se (CLE) {$ jgrid.hideModal ("#" + $ jgrid.jqID (IDs.themodal), {gb:. p.gbox, jqm: p.jqModal, OnClose:. rp_ge [$ TPID] onClose}) ;}
						return false;
					}
					if (rp_ge [$ TPID]. navkeys [0] === true) {
						if (. $ ("# id_g", frmtb) val () === "_empty") {return true;}
						if (e.which === rp_ge [$ TPID]. navkeys [1]) {/ / se
							. $ ("#", PData frmtb + "_2") gatilho ("click");
							return false;
						}
						if (e.which === rp_ge [$ TPID]. navkeys [2]) {/ / para baixo
							. $ ("# NData", frmtb + "_2") gatilho ("click");
							return false;
						}
					}
				});
				if (p.checkOnUpdate) {
					$ ("A.ui-jqdialog-titlebar-próximo período", "#" + $ jgrid.jqID (IDs.themodal).) RemoveClass ("jqmClose").;
					$ ("A.ui-jqdialog-titlebar de perto", "#" + $. Jgrid.jqID (IDs.themodal)). Desvincular ("click")
					. Click (function () {
						if (checkUpdates (!)) {return false;}
						$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID(gID),jqm:p.jqModal,onClose: rp_ge [$ TPID] onClose}).;
						return false;
					});
				}
				. p.saveicon = $ estender ([true, "esquerda", "ui-icon-disk"], p.saveicon);
				. p.closeicon = $ estender ([true, "esquerda", "ui-icon-perto"], p.closeicon);
				/ / Beforeinitdata após a criação da forma
				if (p.saveicon [0] === true) {
					$ ("# SData", frmtb + "_2") addClass. (P.saveicon [1] === "direito" 'fm-botão-ícone com o botão direito': 'botão fm-icon-esquerda ")
					. Append ("<span class='ui-icon "+p.saveicon[2]+"'> </ span>");
				}
				if (p.closeicon [0] === true) {
					. $ ("# CData", frmtb + "_2") addClass (p.closeicon [1] === "direito" 'fm-botão-ícone com o botão direito': 'botão fm-icon-esquerda ")
					. Append ("<span class='ui-icon "+p.closeicon[2]+"'> </ span>");
				}
				if (rp_ge [$ TPID] checkOnSubmit |. |. rp_ge [$ TPID] checkOnUpdate) {
					bs = "<a id='sNew' class='fm-button ui-state-default ui-corner-all' style='z-index:1002'>" + p.bYes + "</ a>";
					BN = "<a id='nNew' class='fm-button ui-state-default ui-corner-all' style='z-index:1002'>" + p.bNo + "</ a>";
					BC = "<a id='cNew' class='fm-button ui-state-default ui-corner-all' style='z-index:1002'>" + p.bExit + "</ a>";
					var zI = p.zIndex | | 999; zI + +;
					$ ("<div Class='"+ p.overlayClass+" jqgrid-overlay confirm' style='z-index:"+zI+";display:none;'>" + "</ div> <div class = 'widget-confirmar o conteúdo ui-ui-jqconfirm' style = 'z-index: "+ (zI +1) +"> "+ p.saveData +" <br/> "+ + bS bN + BC + "</ div>") insertAfter ("#" + frmgr).;
					$ ("# Snew", "#" + $. Jgrid.jqID (IDs.themodal)). Click (function () {
						Post-it ();
						$ ("#" + Frmgr) de dados ("desativado", false).;
						. $ (".. Confirmar", "#" + $ jgrid.jqID (IDs.themodal)) hide ();
						return false;
					});
					$ ("# NNovo", "#" + $. Jgrid.jqID (IDs.themodal)). Click (function () {
						. $ (".. Confirmar", "#" + $ jgrid.jqID (IDs.themodal)) hide ();
						$ ("#" + Frmgr) de dados ("desativado", false).;
						setTimeout (function () {. $ (": Entrada: Visível", "#" + frmgr) [0] se concentrar ();}, 0);
						return false;
					});
					$ ("# CNew", "#" + $. Jgrid.jqID (IDs.themodal)). Click (function () {
						. $ (".. Confirmar", "#" + $ jgrid.jqID (IDs.themodal)) hide ();
						$ ("#" + Frmgr) de dados ("desativado", false).;
						$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID(gID),jqm:p.jqModal,onClose: rp_ge [$ TPID] onClose}).;
						return false;
					});
				}
				/ / Aqui initForm - apenas uma vez
				. $ ($ T) triggerHandler ("jqGridAddEditInitializeForm" [$ ("#" + frmgr), frmoper]);
				if (onInitializeForm) {onInitializeForm.call ($ t, $ ("#" + frmgr), frmoper);}
				if (rowid === "_empty" | | rp_ge [$] TPID viewPagerButtons!.) {$ ("# pData, # NDATA", frmtb + "_2") hide ();.} else {$ ("# pData, . # nData ", frmtb +" _2 ") show ();}
				. $ ($ T) triggerHandler ("jqGridAddEditBeforeShowForm" [$ ("#" + frmgr), frmoper]);
				if (onBeforeShow) {onBeforeShow.call ($ t, $ ("#" + frmgr), frmoper);}
				$ Dados ("onClose", rp_ge [$ TPID] onClose.) ("#" + $ Jgrid.jqID (IDs.themodal).).;
				Jgrid.viewModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gbox:.. "# Gbox_" + $ jgrid.jqID (GID), jqm:. P.jqModal, overlay: p.overlay, modal: p.modal, overlayClass: p.overlayClass});
				if (closeovrl!) {
					$ ("." + $. Jgrid.jqID (p.overlayClass)). Click (function () {
						if (checkUpdates (!)) {return false;}
						Jgrid.hideModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gb:.. "# Gbox_" + $ jgrid.jqID (GID), jqm:. P.jqModal, OnClose: rp_ge [$ TPID ] onClose}).;
						return false;
					});
				}
				. $ ($ T) triggerHandler ("jqGridAddEditAfterShowForm" [$ ("#" + frmgr), frmoper]);
				if (onAfterShow) {onAfterShow.call ($ t, $ ("#" + frmgr), frmoper);}
				("Botão de fm.", "#" + $. Jgrid.jqID (IDs.themodal)) $. Pairar (
					function () {$ (this) addClass ('ui-state-pairar');.}
					function () {$ (this) removeClass ('ui-state-pairar');.}
				);
				$ ("# SData", frmtb + "_2"). Click (function () {
					postdata = {};
					. $ ("# FormError", frmtb) hide ();
					/ / Todos dependem de disposição ret
					/ / Ret [0] - sucessão
					/ / Ret [1] - se não msg sucessão
					/ / Ret [2] - o id que será definido se recarregar depois de apresentar falso
					getFormData ();
					if (postdata [$ TPID + "_id"] === "_empty") {post-it ();}
					else if (p.checkOnSubmit === true) {
						diff = CompareData (postdata, rp_ge [$ TPID] _savedData.);
						if (diff) {
							$ ("#" + Frmgr) dados ("deficientes", true).;
							. $ (".. Confirmar", "#" + $ jgrid.jqID (IDs.themodal)) show ();
						} Else {
							Post-it ();
						}
					} Else {
						Post-it ();
					}
					return false;
				});
				$ ("# CData", frmtb + "_2"). Click (function () {
					if (checkUpdates (!)) {return false;}
					$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID(gID),jqm:p.jqModal,onClose: rp_ge [$ TPID] onClose}).;
					return false;
				});
				$ ("# NData", frmtb + "_2"). Click (function () {
					if (checkUpdates (!)) {return false;}
					. $ ("# FormError", frmtb) hide ();
					npos var = getCurrPos ();
					npos [0] = parseInt (npos [0], 10);
					if (npos [0]! == -1 && npos [1] [npos [0] +1]) {
						. $ ($ T) triggerHandler ("jqGridAddEditClickPgButtons", ['Next', $ ("#" + frmgr), npos [1] [npos [0]]]);
						var nposret;
						if ($. isFunction (p.onclickPgButtons)) {
							nposret = p.onclickPgButtons.call ($ t, 'next', $ ("#" + frmgr), npos [1] [npos [0]]);
							if (! == nposret indefinido && nposret === false) {return false;}
						}
						if ($ ("#" + $ jgrid.jqID (npos [1] [npos [0] 1])) hasClass ('ui-state-deficientes ")..) {return false;}
						fillData (npos [1] [npos [0] 1], $ t, frmgr);
						. $ ($ T) jqGrid ("setSelection", npos [1] [npos [0] 1]);
						. $ ($ T) triggerHandler ("jqGridAddEditAfterClickPgButtons", ['Next', $ ("#" + frmgr), npos [1] [npos [0]]]);
						if ($. isFunction (p.afterclickPgButtons)) {
							p.afterclickPgButtons.call ($ t, 'next', $ ("#" + frmgr), npos [1] [npos [0] 1]);
						}
						updateNav (npos [0] +1, npos);
					}
					return false;
				});
				$ ("#", PData frmtb + "_2"). Click (function () {
					if (checkUpdates (!)) {return false;}
					. $ ("# FormError", frmtb) hide ();
					OPP var = getCurrPos ();
					if (OPP [0]! == -1 && OPP [1] [OPP [0] -1]) {
						. $ ($ T) triggerHandler ("jqGridAddEditClickPgButtons", ['prev', $ ("#" + frmgr), OPP [1] [OPP [0]]]);
						var pposret;
						if ($. isFunction (p.onclickPgButtons)) {
							pposret = p.onclickPgButtons.call ($ t, 'prev', $ ("#" + frmgr), OPP [1] [OPP [0]]);
							if (pposret == indefinido && pposret === false!) {return false;}
						}
						if ($ ("#" + $ jgrid.jqID (OPP [1] [OPP [0] -1])) hasClass ('ui-state-deficientes ")..) {return false;}
						fillData (OPP [1] [OPP [0] -1], $ t, frmgr);
						. $ ($ T) jqGrid ("setSelection", OPP [1] [OPP [0] -1]);
						. $ ($ T) triggerHandler ("jqGridAddEditAfterClickPgButtons", ['prev', $ ("#" + frmgr), OPP [1] [OPP [0]]]);
						if ($. isFunction (p.afterclickPgButtons)) {
							p.afterclickPgButtons.call ($ t, 'prev', $ ("#" + frmgr), OPP [1] [OPP [0] -1]);
						}
						updateNav (OPP [0] -1, OPP);
					}
					return false;
				});
			}
			var posInit getCurrPos = ();
			updateNav (posInit [0], posInit);

		});
	},
	viewGridRow: function (rowid, p) {
		p = $. estender (true, {
			top: 0,
			esquerda: 0,
			largura: 0,
			datawidth: 'auto',
			height: 'auto',
			dataheight: 'auto',
			modal: false,
			sobreposição: 30,
			arrasto: true,
			redimensionar: true,
			jqModal: true,
			closeOnEscape: false,
			labelswidth: '30% ',
			closeicon: [],
			navkeys: [falso, 38,40],
			onClose: null,
			beforeShowForm: null,
			beforeInitData: null,
			viewPagerButtons: verdadeiro,
			recreateForm: false
		}, $ Jgrid.view, p | | {}).;
		rp_ge [. $ (this) [0] p.id] = p;
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid | | rowid!) {return;}
			var gid = $ TPID,
			frmgr = "ViewGrid_" + $. jgrid.jqID (GID), frmtb = "ViewTbl_" + $. jgrid.jqID (GID),
			frmgr_id = "ViewGrid_" + GID, frmtb_id = "ViewTbl_" + GID,
			IDs = {themodal: 'viewmod' + GID, modalhead: 'viewhd' + GID, modalcontent: 'viewcnt' + GID, scrollelm: frmgr},
			onBeforeInit = $. isFunction (rp_ge [$ TPID]. beforeInitData)? . rp_ge [$ TPID] beforeInitData: false,
			showFrm = true,
			maxCols = 1, maxRows = 0;
			if (p.recreateForm === verdadeiro && $ ("#" + $. jgrid.jqID (IDs.themodal)) [0]! == undefined) {
				$ ("#" + $ Jgrid.jqID (IDs.themodal).) Remove ().;
			}
			focusaref função () {/ / Sfari três questões
				if (rp_ge [$ TPID] closeOnEscape === true |. |. rp_ge [$] TPID navkeys [0] === true) {
					setTimeout (function () {$ ("#" + $ jgrid.jqID (IDs.modalhead)) foco () "ui-jqdialog-titlebar de perto.";..}, 0);
				}
			}
			createData função (ROWID, obj tb, maxcols) {
				var nm, hc, trdata, cnt = 0, tmp, dc, retpos = [], ind = false, i,
				tdtmpl = "<td class='CaptionTD form-view-label ui-widget-content' width='"+p.labelswidth+"'> </ td> <td class = 'forma-view-dados DataTD ui-ajudante-reset ui-widget-content '> </ td> ", tmpl =" ",
				tdtmpl2 = "<td class='CaptionTD form-view-label ui-widget-content'> </ td> <td class='DataTD form-view-data ui-widget-content'> , </ td> ",
				fmtnum = ['integer', 'número', 'moeda'], max1 = 0, max2 = 0, maxw, setme, viewfld;
				for (i = 1; i <= maxcols; i + +) {
					tmpl + i = 1 ===? tdtmpl: tdtmpl2;
				}
				/ / Encontra max rigth número alinhar com a propriedade formatador
				$ (Obj.p.colModel). Cada (function () {
					if (this.editrules && this.editrules.edithidden === true) {
						hc = false;
					} Else {
						hc = this.hidden === verdade? verdadeiro: false;
					}
					if (! hc && this.align === 'direito') {
						if ($ this.formatter &&. inArray (this.formatter, fmtnum)! == -1) {
							max1 = Math.max (max1, parseInt (this.width, 10));
						} Else {
							max2 = Math.max (max2, parseInt (this.width, 10));
						}
					}
				});
				maxw = max1! == 0? max1: max2 == 0? max2: 0;
				ind = $ (obj) jqGrid ("getInd", rowid).;
				$ (Obj.p.colModel). Cada (function (i) {
					nm = this.name;
					setme = false;
					Campos / / ocultas são incluídas no formulário
					if (this.editrules && this.editrules.edithidden === true) {
						hc = false;
					} Else {
						hc = this.hidden === verdade? verdadeiro: false;
					}
					dc = hc? "Style =" display: none "": "";
					viewfld = (typeof this.viewable! == 'boolean')? verdadeiro: this.viewable;
					if (nm! == 'cb' && nm! == 'subgrid' && nm! == 'rn' && viewfld) {
						if (ind === false) {
							tmp = "";
						} Else {
							if (nm === obj.p.ExpandColumn && obj.p.treeGrid === true) {
								. tmp = $ ("td: eq (" + i + ")", obj.rows [ind]) text ();
							} Else {
								. tmp = $ ("td: eq (" + i + ")", obj.rows [ind]) html ();
							}
						}
						setme = this.align === 'direito' && maxw! == 0? verdadeiro: false;
						. var frmopt = $ estender ({}, {rowabove: false, rowcontent:''}, this.formoptions | | {}),
						rp = parseInt (frmopt.rowpos, 10) | | cnt +1,
						cp = parseInt ((parseInt (frmopt.colpos, 10) | | 1) * 2,10);
						if (frmopt.rowabove) {
							var newdata = $ ("<td class='contentinfo' colspan='"+(maxcols*2)+"'>" + frmopt.rowcontent + "</ td> </ tr>");
							. $ (Tb) append (newdata);
							newdata [0] = rp rp.;
						}
						trdata = $ (tb) find ("tr [rowpos =" + rp + "]").;
						if (trdata.length === 0) {
							trdata = $ ("<tr "+dc+" rowpos='"+rp+"'> </ tr>") addClass ("FormData") attr ("id", "trv_" + nm)..;
							. $ (Trdata) append (tmpl);
							. $ (Tb) append (trdata);
							trdata [0] = rp rp.;
						}
						$.? ("Td: eq (" + (CP-2) + ")", trdata [0]) html ('<b>' + (frmopt.label === indefinido obj.p.colNames [i] : frmopt.label) + '</ b>');
						$.. ("Td: eq (" + (CP-1) + ")", trdata [0]) append ("<span>" + tmp + "</ span>") attr ("id", "v_ "+ nm);
						if (setme) {
							$ ("Td: eq (" + (CP-1) + ") período", trdata [0]) css ({'text-align': 'certo', largura: maxw + "px"}).;
						}
						retpos [CNT] = i;
						cnt + +;
					}
				});
				if (cnt> 0) {
					var idrow = $ ("<tr class='FormData' style='display:none'> <td class='CaptionTD'> </ td> <td colspan = '" + (maxcols * 2-1) + "' class = "DataTD> <input class='FormElement' id='id_g' type='text' name='id' value='"+rowid+"'/> </ td> </ tr>");
					. idrow [0] = rp cnt 99;
					. $ (Tb) append (idrow);
				}
				voltar retpos;
			}
			função fillData (rowid, obj) {
				var nm, hc, cnt = 0, tmp, trv;
				TRV = $ (obj) jqGrid ("getInd", rowid, true).;
				Se {return;} (TRV!)
				$ ('Td', TRV). Cada (function (i) {
					. nm = obj.p.colModel [i] nome;
					Campos / / ocultas são incluídas no formulário
					if (obj.p.colModel [i]. editrules && obj.p.colModel [i]. editrules.edithidden === true) {
						hc = false;
					} Else {
						hc = obj.p.colModel [i]. escondido === verdade? verdadeiro: false;
					}
					if (nm! == 'cb' && nm! == 'subgrid' && nm! == 'rn') {
						if (nm === obj.p.ExpandColumn && obj.p.treeGrid === true) {
							tmp = $ (this) text ().;
						} Else {
							tmp = $ (this) html ().;
						}
						nm = $ jgrid.jqID ("v_" + nm).;
						. $ ("#" + Nm + "span", "#" + frmtb) html (tmp);
						if (hc) {.. $ ("#" + nm, "#" + frmtb) pais ("tr: primeiro") hide ();}
						cnt + +;
					}
				});
				if (cnt> 0) {$ ("# id_g", "#" + frmtb) val (rowid);.}
			}
			função updateNav (cr, posarr) {
				. var TOTR = posarr [1] Comprimento-1;
				if (cr === 0) {
					$ ("# PData", "#" + frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else if (posarr [1] [cr-1]! == Indefinido && $ ("#" + $. Jgrid.jqID (posarr [1] [cr-1])). HasClass ('ui-state-desativado ')) {
					$ ("#", PData frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else {
					$ ("# PData", "#" + frmtb + "_2") removeClass ('ui-state-deficientes ").;
				}
				if (cr === TOTR) {
					$ ("# NData", "#" + frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else if (posarr [1] [cr +1]! == Indefinido && $ ("#" + $. Jgrid.jqID (posarr [1] [cr +1])). HasClass ('ui-state-desativado ')) {
					$ ("# NData", frmtb + "_2") addClass ('ui-state-deficientes ").;
				} Else {
					. $ ("# NData", "#" + frmtb + "_2") removeClass ('ui-state-deficientes ");
				}
			}
			getCurrPos function () {
				var rowsInGrid = $ ($ t). jqGrid ("getDataIDs"),
				selrow = $ ("# id_g", "#" + frmtb). val (),
				pos = $ inArray (selrow, rowsInGrid).;
				voltar [pos, rowsInGrid];
			}

			if ($ ("#" + $. jgrid.jqID (IDs.themodal)) [0]! == undefined) {
				if (onBeforeInit) {
					showFrm = onBeforeInit.call ($ t, $ ("#" + frmgr));
					if (showFrm === indefinido) {
						showFrm = true;
					}
				}
				if (showFrm === false) {return;}
				$ (". Ui-jqdialog-título", "#" + $ jgrid.jqID (IDs.modalhead).) Html (p.caption).;
				. $ ("# FormError", "#" + frmtb) hide ();
				fillData (rowid, $ t);
				Se {rp_ge [$ TPID] beforeShowForm.call ($ t, $ ("#" + frmgr)).;} ($ isFunction (rp_ge [$ TPID] beforeShowForm).).
				Jgrid.viewModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gbox:... "# Gbox_" + $ jgrid.jqID (GID), jqm: p.jqModal, jqM: false, overlay: p.overlay, modal: p.modal});
				focusaref ();
			} Else {
				var dh = isNaN (p.dataheight)? p.dataheight: p.dataheight + "px",
				dw = isNaN (p.datawidth)? p.datawidth: p.datawidth + "px",
				frm = $ ("<nome do formulário = id 'FormPost' = '" + frmgr_id + "' class = estilo 'formGrid' = 'width:" + dw + "; overflow: auto; position: relative; altura:" + dh + "; '> </ form> "),
				tbl = $ ("<table id='"+frmtb_id+"' class='EditTable' cellspacing='1' cellpadding='2' border='0' style='table-layout:fixed'> <tbody> </ tbody> </ table> ");
				if (onBeforeInit) {
					showFrm = onBeforeInit.call ($ t, $ ("#" + frmgr));
					if (showFrm === indefinido) {
						showFrm = true;
					}
				}
				if (showFrm === false) {return;}
				$ ($ TpcolModel) cada (função. () {
					var fmto = this.formoptions;
					maxCols = Math.max (? maxCols, fmto fmto.colpos | | 0: 0);
					maxRows = Math.max (maxRows, fmto fmto.rowpos | | 0: 0);
				});
				/ / Definir o id.
				. $ (FRM) append (TBL);
				createData (rowid, $ t, tbl, maxCols);
				var rtlb = $ tpdirection === "RTL"? verdadeiro: false,
				bp = rtlb? "NDATA": "", pData
				BN = rtlb? "PData": "nData",

				/ / botões no rodapé
				bP = "<a id='"+bp+"' class='fm-button ui-state-default ui-corner-left'> <span class='ui-icon ui-icon-triangle-1-w'> </ span> </ a> ",
				BN = "<a id='"+bn+"' class='fm-button ui-state-default ui-corner-right'> <span class='ui-icon ui-icon-triangle-1-e'> </ span> </ a> ",
				BC = "<a id='cData' class='fm-button ui-state-default ui-corner-all'>" + p.bClose + "</ a>";
				if (maxRows> 0) {
					var sd = [];
					$. Cada ($ (TBL) [0]. Linhas, função (i, r) {
						sd [i] = r;
					});
					sd.sort (function (a, b) {
						if (a.rp> b.rp) {return 1;}
						if (a.rp <b.rp) {return 1;}
						return 0;
					});
					$. Cada (sd, função (index, linha) {
						. $ ('Tbody ", tbl) anexar (linha);
					});
				}
				. p.gbox = "# gbox_" + $ jgrid.jqID (GID);
				var bt = $ ("<div> </ div>"). anexar (FRM). append ("<table border='0' class='EditTable' id='"+frmtb+"_2'> <tbody> < id = tr 'Act_Buttons'> <td class='navButton' width='"+p.labelswidth+"'> "+ (rtlb bN + BP:? bP + bi) +" </ td> <td class = 'EditButton > "+ BC +" </ td> </ tr> </ tbody> </ table> ");
				. $ Jgrid.createModal (IDs, bt, p, "# gview_" + $ jgrid.jqID ($ TPID), $ ("# gview_" + $ jgrid.jqID ($ TPID)) [0]..);
				if (rtlb) {
					. $ ("# PData, # nData", "#" + frmtb + "_2") css ("flutuar", "direito");
					. $ (". EditButton", "#" + frmtb + "_2") css ("text-align", "esquerda");
				}
				if (!) p.viewPagerButtons {$ ("# pData, # nData", "#" + frmtb + "_2") hide ();.}
				bt = null;
				$ ("#" + IDs.themodal). Keydown (function (e) {
					if (e.which === 27) {
						if (rp_ge [$ TPID] closeOnEscape.) {$ jgrid.hideModal ("#" + $ jgrid.jqID (IDs.themodal), {gb:. p.gbox., jqm: p.jqModal, OnClose: p.onClose });}
						return false;
					}
					if (p.navkeys [0] === true) {
						if (e.which === p.navkeys [1]) {/ / se
							. $ ("# PData", "#" + frmtb + "_2") gatilho ("click");
							return false;
						}
						if (e.which === p.navkeys [2]) {/ / para baixo
							. $ ("# NData", "#" + frmtb + "_2") gatilho ("click");
							return false;
						}
					}
				});
				. p.closeicon = $ estender ([true, "esquerda", "ui-icon-perto"], p.closeicon);
				if (p.closeicon [0] === true) {
					$ ("# CData", "#" + frmtb + "_2") addClass (p.closeicon [1] === "direito" 'fm-botão-ícone com o botão direito':.? Fm-botão-icon-esquerda ')
					. Append ("<span class='ui-icon "+p.closeicon[2]+"'> </ span>");
				}
				Se {p.beforeShowForm.call ($ t, $ ("#" + frmgr));} ($ isFunction (p.beforeShowForm).)
				$.jgrid.viewModal("#"+$.jgrid.jqID(IDs.themodal),{gbox:"#gbox_"+$.jgrid.jqID(gID),jqm:p.jqModal,overlay: p.overlay, modal: p.modal});
				$. ("Botão fm:.. Não (ui-state-desativado)", "#" + frmtb + "_2") pairar (
					function () {$ (this) addClass ('ui-state-pairar');.}
					function () {$ (this) removeClass ('ui-state-pairar');.}
				);
				focusaref ();
				$ ("# CData", "#" + frmtb + "_2"). Click (function () {
					Jgrid.hideModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gb:. "# Gbox_" + $ jgrid.jqID (GID), jqm: p.jqModal, onClose: p.onClose}.. );
					return false;
				});
				$ ("# NData", "#" + frmtb + "_2"). Click (function () {
					. $ ("# FormError", "#" + frmtb) hide ();
					npos var = getCurrPos ();
					npos [0] = parseInt (npos [0], 10);
					if (npos [0]! == -1 && npos [1] [npos [0] +1]) {
						if ($. isFunction (p.onclickPgButtons)) {
							p.onclickPgButtons.call ($ t, 'next', $ ("#" + frmgr), npos [1] [npos [0]]);
						}
						fillData (npos [1] [npos [0] 1], $ t);
						. $ ($ T) jqGrid ("setSelection", npos [1] [npos [0] 1]);
						if ($. isFunction (p.afterclickPgButtons)) {
							p.afterclickPgButtons.call ($ t, 'next', $ ("#" + frmgr), npos [1] [npos [0] 1]);
						}
						updateNav (npos [0] +1, npos);
					}
					focusaref ();
					return false;
				});
				$ ("# PData", "#" + frmtb + "_2"). Click (function () {
					. $ ("# FormError", "#" + frmtb) hide ();
					OPP var = getCurrPos ();
					if (OPP [0]! == -1 && OPP [1] [OPP [0] -1]) {
						if ($. isFunction (p.onclickPgButtons)) {
							p.onclickPgButtons.call ($ t, 'prev', $ ("#" + frmgr), OPP [1] [OPP [0]]);
						}
						fillData (OPP [1] [OPP [0] -1], $ t);
						. $ ($ T) jqGrid ("setSelection", OPP [1] [OPP [0] -1]);
						if ($. isFunction (p.afterclickPgButtons)) {
							p.afterclickPgButtons.call ($ t, 'prev', $ ("#" + frmgr), OPP [1] [OPP [0] -1]);
						}
						updateNav (OPP [0] -1, OPP);
					}
					focusaref ();
					return false;
				});
			}
			var posInit getCurrPos = ();
			updateNav (posInit [0], posInit);
		});
	},
	delGridRow: function (rowids, p) {
		p = $. estender (true, {
			top: 0,
			esquerda: 0,
			width: 240,
			height: 'auto',
			dataheight: 'auto',
			modal: false,
			sobreposição: 30,
			arrasto: true,
			redimensionar: true,
			url:'',
			mtype: "POST",
			reloadAfterSubmit: true,
			beforeShowForm: null,
			beforeInitData: null,
			afterShowForm: null,
			beforeSubmit: null,
			onclickSubmit: null,
			afterSubmit: null,
			jqModal: true,
			closeOnEscape: false,
			delData: {},
			delicon: [],
			cancelicon: [],
			onClose: null,
			ajaxDelOptions: {},
			processamento: false,
			serializeDelData: null,
			useDataProxy: false
		}, $ Jgrid.del, p | | {}).;
		rp_ge [. $ (this) [0] p.id] = p;
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid!) {return;}
			Se {return;} (rowids!)
			var onBeforeShow = $. isFunction (rp_ge [$ TPID]. beforeShowForm),
			onAfterShow = $. isFunction (rp_ge [$ TPID]. afterShowForm),
			onBeforeInit = $. isFunction (rp_ge [$ TPID]. beforeInitData)? . rp_ge [$ TPID] beforeInitData: false,
			gid = $ TPID, oncs = {},
			showFrm = true,
			dtbl = "DelTbl_" + $. jgrid.jqID (GID), postd, idname, opers, oper,
			dtbl_id = "DelTbl_" + GID,
			IDs = {themodal: 'delmod' + GID, modalhead: 'delhd' + GID, modalcontent: 'delcnt' + GID, scrollelm: dtbl};
			Se {rowids = rowids.join ();} ($ isArray (rowids).)
			if ($ ("#" + $. jgrid.jqID (IDs.themodal)) [0]! == undefined) {
				if (onBeforeInit) {
					showFrm = onBeforeInit.call ($ t, $ ("#" + dtbl));
					if (showFrm === indefinido) {
						showFrm = true;
					}
				}
				if (showFrm === false) {return;}
				. $ ("# DelData> td", "#" + dtbl) texto (rowids);
				. $ ("# DelError", "#" + dtbl) hide ();
				if (rp_ge [$ TPID]. processamento === true) {
					. rp_ge [$ TPID] processamento = false;
					$ ("# DData", "#" + dtbl) removeClass ('ui-state-activo »).;
				}
				if (onBeforeShow) {rp_ge [$ TPID] beforeShowForm.call ($ t, $ ("#" + dtbl));.}
				$.jgrid.viewModal("#"+$.jgrid.jqID(IDs.themodal),{gbox:"#gbox_"+$.jgrid.jqID(gID),jqm:rp_ge[$tpid].jqModal,jqM: .. falsa, overlay: rp_ge [$ TPID] sobreposição, modal: rp_ge [$ TPID] modal});
				if (onAfterShow) {rp_ge [$ TPID] afterShowForm.call ($ t, $ ("#" + dtbl));.}
			} Else {
				var dh = isNaN (rp_ge [$ TPID]. dataheight)? . rp_ge [$ TPID] dataheight:. rp_ge [$ TPID] dataheight + "px",
				dw = isNaN (p.datawidth)? p.datawidth: p.datawidth + "px",
				tbl = "<div id='"+dtbl_id+"' class='formdata' style='width:"+dw+";overflow:auto;position:relative;height:"+dh+";'>";
				tbl + = "<table class='DelTable'> <tbody>";
				/ / Dados de erro
				tbl + = "<tr id='DelError' style='display:none'> <td class='ui-state-error'> </ td> </ tr>";
				tbl + = "<tr id='DelData' style='display:none'> <td>" + rowids + "</ td> </ tr>";
				tbl + = "<td class=\"delmsg\" style=\"white-space:pre;\">" + rp_ge [$ TPID]. msg + "</ td> </ tr> <td> </ td> </ tr> ";
				/ / botões no rodapé
				tbl + = "</ tbody> </ table> </ div>";
				var bs = "<a id='dData' class='fm-button ui-state-default ui-corner-all'>" + p.bSubmit + "</ a>",
				BC = "<a id='eData' class='fm-button ui-state-default ui-corner-all'>" + p.bCancel + "</ a>";
				tbl + = "<table cellspacing='0' cellpadding='0' border='0' class='EditTable' id='"+dtbl+"_2'> <tbody> <tr> <td> <class hr = ' conteúdo ui-widget-'style = "margin: 1px" /> </ td> </ tr> <td class='DelButton EditButton'> "+ Bs +" "+ BC +" </ td > </ tr> </ tbody> </ table> ";
				. p.gbox = "# gbox_" + $ jgrid.jqID (GID);
				. $ Jgrid.createModal (IDs, tbl, p, "# gview_" + $ jgrid.jqID ($ TPID), $ ("# gview_" + $ jgrid.jqID ($ TPID)) [0]..);

				if (onBeforeInit) {
					showFrm = onBeforeInit.call ($ t, $ ("#" + dtbl));
					if (showFrm === indefinido) {
						showFrm = true;
					}
				}
				if (showFrm === false) {return;}

				$ (". Botão fm", "#" + dtbl + "_2"). Pairar (
					function () {$ (this) addClass ('ui-state-pairar');.}
					function () {$ (this) removeClass ('ui-state-pairar');.}
				);
				. p.delicon = $ estender ([true, "esquerda", "ui-icon-tesoura"], rp_ge [$ TPID] delicon.);
				. p.cancelicon = $ estender ([true, "esquerda", "ui-icon-cancelar"], rp_ge [$ TPID] cancelicon.);
				if (p.delicon [0] === true) {
					$ ("# DData", "#" + dtbl + "_2") addClass (p.delicon [1] === "direito" 'fm-botão-ícone com o botão direito':.? Fm-botão-icon-esquerda ')
					. Append ("<span class='ui-icon "+p.delicon[2]+"'> </ span>");
				}
				if (p.cancelicon [0] === true) {
					. $ ("# Edata", "#" + dtbl + "_2") addClass (p.cancelicon [1] === "direito" 'fm-botão-ícone com o botão direito': 'fm-botão-icon-esquerda ')
					. Append ("<span class='ui-icon "+p.cancelicon[2]+"'> </ span>");
				}
				$ ("# DData", "#" + dtbl + "_2"). Click (function () {
					var ret = [true, ""], pk,
					. postdata = $ ("# DelData> td", "#" + dtbl) texto () / / o par é name = val1, val2, ...
					oncs = {};
					Se {oncs = rp_ge [$ TPID] onclickSubmit.call ($ t, rp_ge [$ TPID], postdata) | | {}.;} ($ isFunction (rp_ge [$ TPID] onclickSubmit).).
					Se {ret = rp_ge [$ TPID] beforeSubmit.call ($ t, postdata).;} ($ isFunction (rp_ge [$ TPID] beforeSubmit).).
					if (ret [0] &&! rp_ge [$ TPID]. processamento) {
						. rp_ge [$ TPID] processamento = true;
						opers = $ tpprmNames;
						. postd = $ estender (. {}, rp_ge [$ TPID] delData, oncs);
						oper = opers.oper;
						postd [oper] = opers.deloper;
						idname = opers.id;
						. postdata = String (postdata) split (",");
						Se {return false;} (postdata.length!)
						for (pk em postdata) {
							if (postdata.hasOwnProperty (pk)) {
								. postdata [pk] = $ jgrid.stripPref ($ tpidPrefix, postdata [pk]);
							}
						}
						postd [idname] = postdata.join ();
						. $ (This) addClass ('ui-estado ativo');
						var AjaxOptions = $. estender ({
							url:.. rp_ge [$ TPID] url | | $ ($ t) jqGrid ('getGridParam', 'editurl'),
							Tipo:. rp_ge [$ TPID] mtype,
							dados:. $ isFunction (rp_ge [$ TPID] serializeDelData.)? . rp_ge [$ TPID] serializeDelData.call ($ t, postd): postd,
							completar: function (dados, status) {
								var i;
								if (data.status> = 300 && data.status! == 304) {
									ret [0] = false;
									if ($. isFunction (rp_ge [$ TPID]. errorTextFormat)) {
										. ret [1] = rp_ge [$ TPID] errorTextFormat.call ($ t, dados);
									} Else {
										ret [1] = Estado + "Estado:" "" código de erro.: "+ data.statusText + '+ data.status;
									}
								} Else {
									/ / Os dados são postados sucesso
									/ / Executar aftersubmit com os dados retornados a partir de servidor
									if ($. isFunction (rp_ge [$ TPID]. afterSubmit)) {
										. ret = rp_ge [$ TPID] afterSubmit.call ($ t, dados, postd);
									}
								}
								if (ret [0] === false) {
									. $ ("# DelError> td", "#" + dtbl) html (ret [1]);
									. $ ("# DelError", "#" + dtbl) show ();
								} Else {
									if (rp_ge [$ TPID]. reloadAfterSubmit && $ tpdatatype! == "local") {
										. $ ($ T) gatilho ("reloadGrid");
									} Else {
										if ($ tptreeGrid === true) {
												try {$ ($ t) jqGrid ("delTreeNode", $ tpidPrefix + postdata [0]);.} catch (e) {}
										} Else {
											for (i = 0; i <postdata.length; i + +) {
												. $ ($ T) jqGrid ("delRowData", $ tpidPrefix + postdata [i]);
											}
										}
										$ Tpselrow = null;
										$ Tpselarrrow = [];
									}
									if ($. isFunction (rp_ge [$ TPID]. afterComplete)) {
										setTimeout (function () {rp_ge [$ TPID] afterComplete.call ($ t, dados, postdata);.}, 500);
									}
								}
								. rp_ge [$ TPID] processamento = false;
								. $ ("# DData", "#" + dtbl + "_2") removeClass ('ui-state-ativo');
								if (ret [0]) {$ jgrid.hideModal ("#" + $ jgrid.jqID (IDs.themodal), {gb:... "# gbox_" + $ jgrid.jqID (GID), jqm: p. jqModal, onClose:. rp_ge [$ TPID] onClose});}
							}
						}, $ Jgrid.ajaxOptions, rp_ge [$ TPID] ajaxDelOptions)..;


						if (! ajaxOptions.url &&! rp_ge [$ TPID]. useDataProxy) {
							if ($. isFunction ($ tpdataProxy)) {
								. rp_ge [$ TPID] useDataProxy = true;
							} Else {
								ret [0] = false; ret [1] + = "" + $ jgrid.errors.nourl.;
							}
						}
						if (ret [0]) {
							if (rp_ge [$ TPID]. useDataProxy) {
								var dpret = $ tpdataProxy.call ($ t, AjaxOptions ", Del_" + $ TPID); 
								if (dpret === indefinido) {
									dpret = [true, ""];
								}
								if (dpret [0] === false) {
									ret [0] = false;
									ret [1] = dpret [1] | |! "Erro ao excluir a linha selecionada" ;
								} Else {
									Jgrid.hideModal $ ("#" + $ jgrid.jqID (IDs.themodal), {gb:.. "# Gbox_" + $ jgrid.jqID (GID), jqm:. P.jqModal, OnClose: rp_ge [$ TPID ] onClose}).;
								}
							}
							else {$ ajax (AjaxOptions);.}
						}
					}

					if (ret [0] === false) {
						. $ ("# DelError> td", "#" + dtbl) html (ret [1]);
						. $ ("# DelError", "#" + dtbl) show ();
					}
					return false;
				});
				$ ("# Edata", "#" + dtbl + "_2"). Click (function () {
					$.jgrid.hideModal("#"+$.jgrid.jqID(IDs.themodal),{gb:"#gbox_"+$.jgrid.jqID(gID),jqm:rp_ge[$tpid].jqModal, onClose:. rp_ge [$ TPID] onClose});
					return false;
				});
				if (onBeforeShow) {rp_ge [$ TPID] beforeShowForm.call ($ t, $ ("#" + dtbl));.}
				$.jgrid.viewModal("#"+$.jgrid.jqID(IDs.themodal),{gbox:"#gbox_"+$.jgrid.jqID(gID),jqm:rp_ge[$tpid].jqModal, . overlay: rp_ge [$ TPID] sobreposição, modal:. rp_ge [$ TPID] modal});
				if (onAfterShow) {rp_ge [$ TPID] afterShowForm.call ($ t, $ ("#" + dtbl));.}
			}
			if (rp_ge [$ TPID]. closeOnEscape === true) {
				setTimeout (function () {$ ("#" + $ jgrid.jqID (IDs.modalhead)) foco () "ui-jqdialog-titlebar de perto.";..}, 0);
			}
		});
	},
	navGrid: function (elem, o, Pedit, padd, pdel, psearch, pView) {
		o = $. estender ({
			edit: verdade,
			editicon: "ui-icon-lápis",
			adicionar: true,
			AddIcon: "ui-icon-plus",
			del: true,
			delicon: "ui-icon-lixo",
			Pesquisa: true,
			searchicon: "ui-icon-pesquisa",
			atualizar: true,
			refreshicon: "ui-icon-refresh",
			refreshstate: 'firstpage',
			vista: false,
			viewicon: "ui-icon-documento",
			posição: "esquerda",
			closeOnEscape: true,
			BeforeRefresh: null,
			AfterRefresh: null,
			cloneToTop: false,
			alertwidth: 200,
			alertheight: 'auto',
			alerttop: null,
			alertleft: null,
			alertzIndex: null
		}, $ Jgrid.nav, o | | {}).;
		voltar this.each (function () {
			if (this.nav) {return;}
			alertIDs var = {themodal: 'alertmod_' + this.p.id, modalhead: 'alerthd_' + this.p.id, modalcontent: 'alertcnt_' + this.p.id},
			$ T = isso, TWD, tdw;
			if ($ t.grid | | typeof elem == 'string'!) {return;}
			if ($ ("#" + alertIDs.themodal) [0] === indefinido) {
				if (o.alertleft! o.alerttop &&!) {
					if (window.innerWidth! == indefinido) {
						o.alertleft = window.innerWidth;
						o.alerttop = window.innerHeight;
					} Else if (document.documentElement! == Indefinido && document.documentElement.clientWidth! == Indefinido && document.documentElement.clientWidth! == 0) {
						o.alertleft = document.documentElement.clientWidth;
						o.alerttop = document.documentElement.clientHeight;
					} Else {
						o.alertleft = 1024;
						o.alerttop = 768;
					}
					o.alertleft = o.alertleft / 2 - parseInt (o.alertwidth, 10) / 2;
					o.alerttop = o.alerttop/2-25;
				}
				$. Jgrid.createModal (alertIDs,
					"<div>" + O.alerttext + "</ div> <span tabindex='0'> <span tabindex='-1' id='jqg_alrt'> </ span> </ span>",
					{ 
						gbox:. "# gbox_" + $ jgrid.jqID ($ TPID),
						jqModal: true,
						arrasto: true,
						redimensionar: true,
						legenda: o.alertcap,
						top: o.alerttop,
						esquerda: o.alertleft,
						width: o.alertwidth,
						height: o.alertheight,
						closeOnEscape: o.closeOnEscape, 
						zIndex: o.alertzIndex
					},
					"# Gview_" + $. Jgrid.jqID ($ TPID),
					$ ("# Gbox_" + $. Jgrid.jqID ($ TPID)) [0],
					verdadeiro
				);
			}
			var clone = 1, i,
			onHoverIn = function () {
				if (! $ (this). hasClass ('ui-estado desativado')) {
					. $ (This) addClass ("ui-state-foco");
				}
			},
			onHoverOut = function () {
				. $ (This) removeClass ("ui-state-foco");
			};
			if (o.cloneToTop && $ tptoppager) {clone = 2;}
			for (i = 0; i <clone; i + +) {
				var tbd,
				navtbl = $ ("<table cellspacing='0' cellpadding='0' border='0' class='ui-pg-table navtable' style='float:left;table-layout:auto;'> <tbody> <tr> </ tr> </ tbody> </ table> "),
				setembro = "<td class='ui-pg-button ui-state-disabled' style='width:4px;'> <span class='ui-separator'> </ span> </ td>",
				PGID, elemids;
				if (i === 0) {
					PGID = elem;
					elemids = $ TPID;
					if (PGID === $ tptoppager) {
						elemids + = "_top";
						clone = 1;
					}
				} Else {
					PGID = $ tptoppager;
					elemids = $ TPID + "_top";
				}
				if ($ tpdirection === "RTL") {$ (navtbl) attr ("dir", "RTL") css ("flutuar", "right");..}
				if (o.add) {
					padd = padd | | {};
					TBD = $ ("<td class='ui-pg-button ui-corner-all'> </ td>");
					$ (TBD). Append ("<div class='ui-pg-div'> <span class='ui-icon "+o.addicon+"'> </ span>" + o.addtext + "</ div> ");
					. $ ("Tr", navtbl) anexar (TBD);
					$ (TBD, navtbl)
					. Attr ({"title": o.addtitle | | "," id: pAdd.id | | "add_" + elemids})
					. Click (function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							if ($. isFunction (o.addfunc)) {
								o.addfunc.call ($ t);
							} Else {
								. $ ($ T) jqGrid ("editGridRow", "novo", padd);
							}
						}
						return false;
					}) Pairar (onHoverIn, onHoverOut).;
					TBD = null;
				}
				if (o.edit) {
					TBD = $ ("<td class='ui-pg-button ui-corner-all'> </ td>");
					Pedit = Pedit | | {};
					$ (TBD). Append ("<div class='ui-pg-div'> <span class='ui-icon "+o.editicon+"'> </ span>" + o.edittext + "</ div> ");
					. $ ("Tr", navtbl) anexar (TBD);
					$ (TBD, navtbl)
					. Attr ({"title": o.edittitle | | "," id: pEdit.id | | "script edit_" + elemids})
					. Click (function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							var sr = $ tpselrow;
							if (sr) {
								if ($. isFunction (o.editfunc)) {
									o.editfunc.call ($ t, sr);
								} Else {
									. $ ($ T) jqGrid ("editGridRow", sr, Pedit);
								}
							} Else {
								. $ Jgrid.viewModal ("#" + alertIDs.themodal, {. Gbox: "# gbox_" + $ jgrid.jqID ($ TPID), jqm: true});
								. $ ("# Jqg_alrt") focus ();
							}
						}
						return false;
					}) Pairar (onHoverIn, onHoverOut).;
					TBD = null;
				}
				if (o.view) {
					TBD = $ ("<td class='ui-pg-button ui-corner-all'> </ td>");
					pView = pView | | {};
					$ (TBD). Append ("<div class='ui-pg-div'> <span class='ui-icon "+o.viewicon+"'> </ span>" + o.viewtext + "</ div> ");
					. $ ("Tr", navtbl) anexar (TBD);
					$ (TBD, navtbl)
					. Attr ({"title": o.viewtitle | | "," id: pView.id | | "View_" + elemids})
					. Click (function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							var sr = $ tpselrow;
							if (sr) {
								if ($. isFunction (o.viewfunc)) {
									o.viewfunc.call ($ t, sr);
								} Else {
									$ ($ T) jqGrid ("viewGridRow", sr, pView).;
								}
							} Else {
								. $ Jgrid.viewModal ("#" + alertIDs.themodal, {. Gbox: "# gbox_" + $ jgrid.jqID ($ TPID), jqm: true});
								. $ ("# Jqg_alrt") focus ();
							}
						}
						return false;
					}) Pairar (onHoverIn, onHoverOut).;
					TBD = null;
				}
				if (o.del) {
					TBD = $ ("<td class='ui-pg-button ui-corner-all'> </ td>");
					pdel = pdel | | {};
					$ (TBD). Append ("<div class='ui-pg-div'> <span class='ui-icon "+o.delicon+"'> </ span>" + o.deltext + "</ div> ");
					. $ ("Tr", navtbl) anexar (TBD);
					$ (TBD, navtbl)
					. Attr ({"title": o.deltitle | | "," id: pDel.id | | "Del_" + elemids})
					. Click (function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							var dr;
							if ($ tpmultiselect) {
								dr = $ tpselarrrow;
								if (dr.length === 0) {dr = null;}
							} Else {
								dr = $ tpselrow;
							}
							if (dr) {
								if ($. isFunction (o.delfunc)) {
									o.delfunc.call ($ t, dr);
								} Else {
									. $ ($ T) jqGrid ("delGridRow", dr, pdel);
								}
							} Else {
								$.jgrid.viewModal("#"+alertIDs.themodal,{gbox:"#gbox_"+$.jgrid.jqID($tpid),jqm:true});$("#jqg_alrt").focus();
							}
						}
						return false;
					}) Pairar (onHoverIn, onHoverOut).;
					TBD = null;
				}
				if (o.add | | o.edit | | o.del | | o.view) {$ ("tr", navtbl) append (setembro);.}
				if (o.search) {
					TBD = $ ("<td class='ui-pg-button ui-corner-all'> </ td>");
					psearch = psearch | | {};
					$ (TBD). Append ("<div class='ui-pg-div'> <span class='ui-icon "+o.searchicon+"'> </ span>" + o.searchtext + "</ div> ");
					. $ ("Tr", navtbl) anexar (TBD);
					$ (TBD, navtbl)
					. Attr ({"title": o.searchtitle | | "," id: pSearch.id | | "a Filtro" + elemids})
					. Click (function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							if ($. isFunction (o.searchfunc)) {
								o.searchfunc.call ($ t, psearch);
							} Else {
								$ ($ T) jqGrid ("searchGrid", psearch).;
							}
						}
						return false;
					}) Pairar (onHoverIn, onHoverOut).;
					if (pSearch.showOnLoad && pSearch.showOnLoad === true) {
						. $ (TBD, navtbl) click ();
					}
					TBD = null;
				}
				if (o.refresh) {
					TBD = $ ("<td class='ui-pg-button ui-corner-all'> </ td>");
					$ (TBD). Append ("<div class='ui-pg-div'> <span class='ui-icon "+o.refreshicon+"'> </ span>" + o.refreshtext + "</ div> ");
					. $ ("Tr", navtbl) anexar (TBD);
					$ (TBD, navtbl)
					. Attr ({"title": o.refreshtitle | | "", id: "Refresh_" + elemids})
					. Click (function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							if ($ isFunction (o.beforeRefresh).) {o.beforeRefresh.call ($ t);}
							$ Tpsearch = false;
							try {
								var gid = $ TPID;
								TppostData.filters $ = "";
								try {
								(". # Fbox_" + $ jgrid.jqID (GID)). $ JqFilter ('resetFilter');
								} Catch (ef) {}
								if ($ isFunction ($ t.clearToolbar).) {$ t.clearToolbar.call ($ t, false);}
							} Catch (e) {}
							switch (o.refreshstate) {
								case 'firstpage':
									. $ ($ T) gatilho ("reloadGrid", [{page: 1}]);
									break;
								caso 'atual':
									. $ ($ T) gatilho ("reloadGrid", [{atual: true}]);
									break;
							}
							if ($ isFunction (o.afterRefresh).) {o.afterRefresh.call ($ t);}
						}
						return false;
					}) Pairar (onHoverIn, onHoverOut).;
					TBD = null;
				}
				. tdw = $ (". ui-jqgrid") css ("font-size") | | "11px";
				$ ('Body'). Append ("<div id='testpg2' class='ui-jqgrid ui-widget ui-widget-content' style='font-size:"+tdw+";visibility:hidden;'> </ div> ");
				... TWD = (navtbl) $ clone () appendTo ("# testpg2") largura ();
				. $ ("# Testpg2") remove ();
				. $ (PGID + "_" + o.position, PGID) append (navtbl);
				if ($ tp_nvtd) {
					if (TWD> $ tp_nvtd [0]) {
						. $ (PGID + "_" + o.position, PGID) largura (TWD);
						$ Tp_nvtd [0] = TWD;
					}
					$ Tp_nvtd [1] = TWD;
				}
				tdw = null; TWD = null; navtbl = null;
				this.nav = true;
			}
		});
	},
	navButtonAdd: function (elem, p) {
		p = $. estender ({
			legenda: "newButton",
			Título:'',
			buttonicon: "ui-icon-newwin ',
			onClickButton: null,
			posição: "durar",
			cursor: 'ponteiro'
		}, P | | {});
		voltar this.each (function () {
			Se {return;} (this.grid!)
			if (typeof elem === "string" && elem.indexOf ("#") == 0!) {elem = "#" + $ jgrid.jqID (elem);.}
			var findnav = $ (". navtable", elem) [0], $ t = this;
			if (findnav) {
				if (p.id && $ ("#" + $ jgrid.jqID (p.id), findnav) [0] == indefinido.!) {return;}
				var TBD = $ ("<td> </ td>");
				if (p.buttonicon.toString (). toUpperCase () === "NONE") {
                    .. $ (TBD) addClass ('botão ui-ui-pg-canto all') append ("<div class='ui-pg-div'>" + p.caption + "</ div>");
				} Else {
					$ (TBD). AddClass ('botão ui-ui-pg-canto tudo'). Append ("<div class='ui-pg-div'> <span class =" ui-icon "+ p.buttonicon +" '> </ span> "+ p.caption +" </ div> ");
				}
				if (p.id) {$ (TBD) attr ("id", p.id);.}
				if (p.position === 'primeiro') {
					if (findnav.rows [0]. cells.length === 0) {
						$ ("Tr", findnav) anexar (TBD).;
					} Else {
						$ ("Tr td: eq (0)", findnav). Antes (TBD);
					}
				} Else {
					$ ("Tr", findnav) anexar (TBD).;
				}
				$ (TBD, findnav)
				. Attr ("title", p.title | | "")
				. Click (function (e) {
					if (! $ (this). hasClass ('ui-estado desativado')) {
						Se {p.onClickButton.call ($ t, e);} ($ isFunction (p.onClickButton).)
					}
					return false;
				})
				. Pairar (
					function () {
						if (! $ (this). hasClass ('ui-estado desativado')) {
							. $ (This) addClass ('ui-state-pairar');
						}
					},
					function () {$ (this) removeClass ("ui-state-foco");.}
				);
			}
		});
	},
	navSeparatorAdd: function (elem, p) {
		p = $. estender ({
			sepclass: "ui-separador",
			sepcontent:'',
			posição: "último"
		}, P | | {});
		voltar this.each (function () {
			Se {return;} (this.grid!)
			if (typeof elem === "string" && elem.indexOf ("#") == 0!) {elem = "#" + $ jgrid.jqID (elem);.}
			var findnav = $ (". navtable", elem) [0];
			if (findnav) {
				var setembro = "<td class='ui-pg-button ui-state-disabled' style='width:4px;'> <span class='"+p.sepclass+"'> </ span>" + p. sepcontent + "</ td>";
				if (p.position === 'primeiro') {
					if (findnav.rows [0]. cells.length === 0) {
						. $ ("Tr", findnav) append (setembro);
					} Else {
						$ ("Tr td: eq (0)", findnav). Antes (setembro);
					}
				} Else {
					. $ ("Tr", findnav) append (setembro);
				}
			}
		});
	},
	GridToForm: function (rowid, formid) {
		voltar this.each (function () {
			var $ t = isso, i;
			if ($ t.grid!) {return;}
			var RowData = $ ($ t) jqGrid ("GetRowData", rowid).;
			if (RowData) {
				for (i in RowData) {
					if (rowdata.hasOwnProperty (i)) {
					if ($ (, formid) é ("input: radio" "[name =" + $ jgrid.jqID (i) + ".]"..) | | $ ("[name =" + $ jgrid.jqID ( . i) + "]", formid) é ("input: checkbox")) {
						$ ("[Name =" + $. Jgrid.jqID (i) + "]", formid). Cada (function () {
							if ($ this (). val () == RowData [i]) {
								$ (This) [$ tpuseProp? 'Sustentar': 'attr'] ("checked", true);
							} Else {
								$ (This) [$ tpuseProp? 'Sustentar': 'attr'] ("checked", false);
							}
						});
					} Else {
					/ / Isto é muito lento na grande mesa e forma.
						$ (, Formid "[name =" + $ jgrid.jqID (i) + ".]") Val (RowData [i]).;
					}
				}
			}
			}
		});
	},
	FormToGrid: function (rowid, formid, modo, posição) {
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid!) {return;}
			Se {mode = 'set';} (modo!)
			se {position = 'primeiro';} (posição!)
			. campos var = $ (formid) serializeArray ();
			var gridData = {};
			$. Cada (campos, a função (i, campo) {
				gridData [field.name] = field.value;
			});
			if (modo === 'add') {$ ($ t) jqGrid ("addRowData", rowid, gridData, posição);.}
			else if (modo === 'set') {$ ($ t) jqGrid ("setRowData", rowid, gridData);.}
		});
	}
});
}) (JQuery);
/ * Jshint eqeqeq: false, eqnull: true, desenvolvi: true * /
/ * JQuery globais * /
(Function ($) {
/ **
 * Extensão jqGrid para manipulação de Data Grid
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/ 
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
** / 
"Use strict";
.. Jgrid.inlineEdit $ = $ jgrid.inlineEdit | | {};
$. Jgrid.extend ({
/ / Edição
	editRow: function (rowid, chaves, oneditfunc, successfunc, url, extraparam, aftersavefunc, errorfunc, afterrestorefunc) {
		Versões / / modo compatível antigos
		.. var o = {}, args = $ MakeArray (argumentos) fatia (1);

		if ($. type (args [0]) === "objeto") {
			o = args [0];
		} Else {
			if (keys == indefinido!) {o.keys = chaves;}
			Se {o.oneditfunc = oneditfunc;} ($ isFunction (oneditfunc).)
			if ($ isFunction (successfunc).) {o.successfunc = successfunc;}
			if (url == indefinido!) {url = o.url;}
			if (extraparam == indefinido!) {o.extraparam = extraparam;}
			Se {o.aftersavefunc = aftersavefunc;} ($ isFunction (aftersavefunc).)
			Se {o.errorfunc = errorfunc;} ($ isFunction (errorfunc).)
			Se {o.afterrestorefunc = afterrestorefunc;} ($ isFunction (afterrestorefunc).)
			/ / Dois últimos não como param, mas como objeto (sorry)
			/ / If (restoreAfterError == indefinido!) {O.restoreAfterError = restoreAfterError;}
			/ / If (mtype == indefinido!) {O.mtype = mtype | | "POST";}			
		}
		o = $. estender (true, {
			chaves: false,
			oneditfunc: null,
			successfunc: null,
			url: null,
			extraparam: {},
			aftersavefunc: null,
			errorfunc: null,
			afterrestorefunc: null,
			restoreAfterError: true,
			mtype: "POST"
		}, $ Jgrid.inlineEdit, o).;

		/ / Fim compatível
		voltar this.each (function () {
			var $ t = isso, nm, tmp, editável, cnt = 0, o foco = null, svr = {}, ind, cm, bfer;
			if ($ t.grid!) {return;}
			ind = $ ($ t) jqGrid ("getInd", rowid, true).;
			if (ind === false) {return;}
			bfer = $. isFunction (o.beforeEditRow)? o.beforeEditRow.call ($ t, o, rowid): undefined;
			if (bfer === indefinido) {
				bfer = true;
			}
			if (bfer!) {return;}
			editável = $ (ind) attr ("editável") | | "0".;
			if (editável === "0" &&! $ (ind). hasClass ("não-editável-fila")) {
				cm = $ tpcolModel;
				$ ('Td [role = "gridcell"] ", ind). Cada (function (i) {
					. nm = cm [i] nome;
					var treeg = $ tptreeGrid === verdadeiro && nm === $ tpExpandColumn;
					if (treeg) {. tmp = $ ("útil: em primeiro lugar", this) html ();}
					else {
						try {
							. tmp = $ unformat.call ($ t, este, {RowId: rowid, colModel: cm [i]}, i);
						} Catch (_) {
							tmp = (cm [i]. EditType && cm [i]. EditType === 'textarea')? . $ (This) text ():. $ (This) html ();
						}
					}
					if (nm! == 'cb' && nm! == 'subgrid' && nm! == 'rn') {
						if ($ tpautoencode) {tmp = $ jgrid.htmlDecode (tmp);.}
						svr [nm] = tmp;
						if (cm [i]. editável === true) {
							if (concentrar === null) {foco = i;}
							if (treeg) {$ ("útil: em primeiro lugar", this). html ("");}
							else {$ (this) html ("");.}
							. var opt = $ estender ({}, cm [i] editoptions | | {}, {id: rowid + "_" + nm, name: nm.});
							Se {cm [i] EditType = "text".;} (cm [i] EditType!).
							if (tmp === "" | | tmp === "" | | (tmp.length === 1 && tmp.charCodeAt (0) === 160)) {tmp ='' ;}
							var elc = | | {}));
							. $ (ELC) addClass ("editável");
							if (treeg) {. $ ("período: primeiro" este), anexar (ELC);}
							else {. $ (this) append (ELC);}
							$ Jgrid.bindEv.call ($ t, elc, opt).;
							/ / Mais uma vez IE
							if (cm [i]. EditType === ", selecione" && cm [i]. editoptions! == && indefinidos cm [i]. editoptions.multiple === verdadeiros && cm [i]. editoptions.dataUrl === && $ indefinido. jgrid.msie) {
								. $ (ELC) largura (. $ (ELC) largura ());
							}
							cnt + +;
						}
					}
				});
				if (cnt> 0) {
					svr.id = rowid; $ tpsavedRow.push (RVS);
					. $ (Ind) attr ("editável", "1");
					$ ("Td: eq (" + foco + ") input", ind). Foco ();
					if (o.keys === true) {
						$ (Ind). Bind ("KeyDown", function (e) {
							if (e.KeyCode === 27) {
								$ ($ T) jqGrid ("restoreRow", rowid, o.afterrestorefunc).;
								if ($ tp_inlinenav) {
									try {
										$ ($ T) jqGrid ('showAddEditButtons').;
									} Catch (eer1) {}
								}
								return false;
							}
							if (=== e.KeyCode 13) {
								var ta = e.target;
								if ('TEXTAREA' ta.tagName ===) {return true;}
								if ($ ($ t). jqGrid ("saveRow", rowid, o)) {
									if ($ tp_inlinenav) {
										try {
											$ ($ T) jqGrid ('showAddEditButtons').;
										} Catch (eer2) {}
									}
								}
								return false;
							}
						});
					}
					. $ ($ T) triggerHandler ("jqGridInlineEditRow" [rowid, o]);
					Se {o.oneditfunc.call ($ t, rowid);} ($ isFunction (o.oneditfunc).)
				}
			}
		});
	},
	saveRow: function (rowid, successfunc, url, extraparam, aftersavefunc, errorfunc, afterrestorefunc) {
		Versões / / modo compatível antigos
		.. var args = $ MakeArray (argumentos) fatia (1), o = {};

		if ($. type (args [0]) === "objeto") {
			o = args [0];
		} Else {
			if ($ isFunction (successfunc).) {o.successfunc = successfunc;}
			if (url == indefinido!) {url = o.url;}
			if (extraparam == indefinido!) {o.extraparam = extraparam;}
			Se {o.aftersavefunc = aftersavefunc;} ($ isFunction (aftersavefunc).)
			Se {o.errorfunc = errorfunc;} ($ isFunction (errorfunc).)
			Se {o.afterrestorefunc = afterrestorefunc;} ($ isFunction (afterrestorefunc).)
		}
		o = $. estender (true, {
			successfunc: null,
			url: null,
			extraparam: {},
			aftersavefunc: null,
			errorfunc: null,
			afterrestorefunc: null,
			restoreAfterError: true,
			mtype: "POST"
		}, $ Jgrid.inlineEdit, o).;
		/ / Fim compatível

		sucesso var = false;
		var $ t = this [0], nm, tmp = {}, tmp2 = {}, tmp3 = {}, editável, fr, cv, ind;
		if ($ t.grid!) {return sucesso;}
		ind = $ ($ t) jqGrid ("getInd", rowid, true).;
		if (ind === false) {return sucesso;}
		var = $ BFSR. isFunction (o.beforeSaveRow)? o.beforeSaveRow.call ($ t, o, rowid): undefined;
		if (BFSR === indefinido) {
			BFSR = true;
		}
		if (BFSR!) {return;}
		editável = $ (ind) attr ("editável").;
		o.url = o.url | | $ tpediturl;
		if (editável === "1") {
			var cm;
			$ ('Td [role = "gridcell"] ", ind). Cada (function (i) {
				cm = $ tpcolModel [i];
				nm = cm.name;
				if (nm! == 'cb' && nm! == 'subgrid' && cm.editable === verdadeiro && nm! == 'rn' &&! $ (this). hasClass ('de células não-editável') ) {
					switch (cm.edittype) {
						caso "checkbox":
							var cbv = ["Sim", "Não"];
							if () {cm.editoptions
								cbv = cm.editoptions.value.split (":");
							}
							tmp [nm] = $ ("input", this) é (": checked").? cbv [0]: cbv [1];
							break;
						caso 'text':
						caso 'password':
						case 'textarea':
						case "botão":
							. tmp [nm] = $ ("input, textarea", this) val ();
							break;
						caso 'selecionar':
							if (cm.editoptions.multiple!) {
								tmp [nm] = $ ("opção de selecção: selecionado", this). val ();
								. tmp2 [nm] = $ ("selecione a opção: selecionado", this) text ();
							} Else {
								var sel = $ ("select", this), SelectedText = [];
								. tmp [nm] = $ (sel) val ();
								if (tmp [nm]) {. tmp [nm] = tmp [nm] join (",");} else {tmp [nm] = "";}
								$ ("Selecione a opção: selecionado", this). Cada (
									função (i, selecionado) {
										. SelectedText [i] = $ (selecionado) text ();
									}
								);
								tmp2 [nm] = selectedText.join (",");
							}
							if (cm.formatter && cm.formatter === 'selecionar') {tmp2 = {};}
							break;
						caso 'custom':
							try {
								if ($ cm.editoptions &&. isFunction (cm.editoptions.custom_value)) {
									tmp [nm] = cm.editoptions.custom_value.call ($ t, $ (". customelement", this), 'get');
									if (tmp [nm] === indefinido) {throw "e2";}
								} Else {throw "e1";}
							} Catch (e) {
								if (e === "e1") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_value '"+ $. jgrid.edit.msg.nodefined, $. jgrid.edit.bClose) ;}
								if (e === "e2") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_value '"+ $. jgrid.edit.msg.novalue, $. jgrid.edit.bClose) ;}
								else {$ jgrid.info_dialog ($ jgrid.errors.errcap, e.Message, $ jgrid.edit.bClose..);.}
							}
							break;
					}
					. cv = $ jgrid.checkValues.call ($ t, tmp [nm], i);
					if (cv [0] === false) {
						return false;
					}
					if ($ tpautoencode) {tmp [nm] = $ jgrid.htmlEncode (tmp [nm]);.}
					if (o.url! == 'clientArray' && cm.editoptions && cm.editoptions.NullIfEmpty === true) {
						if (tmp [nm] === "") {
							tmp3 [nm] = 'nulo';
						}
					}
				}
			});
			if (cv [0] === false) {
				try {
					var tr = $ ($ t) jqGrid ('getGridRowById ", rowid), as posições = $ jgrid.findPos (TR)..;
					$.jgrid.info_dialog($.jgrid.errors.errcap,cv[1],$.jgrid.edit.bClose,{left:positions[0],top:positions[1]+$(tr).outerHeight()});
				} Catch (e) {
					alert (cv [1]);
				}
				retornar com êxito;
			}
			var idname, opers = $ tpprmNames, oldRowId = rowid;
			if ($ tpkeyIndex === false) {
				idname = opers.id;
			} Else {
				idname = $ tpcolModel [$ tpkeyIndex +
					($ tprownumbers === verdadeiro 1: 0) +
					($ Tpmultiselect === verdadeiro 1: 0) +
					. (? $ TpsubGrid === verdadeiro 1: 0)] nome;
			}
			if (tmp) {
				tmp [opers.oper] = opers.editoper;
				if (tmp [idname] === indefinido | | tmp [idname] === "") {
					tmp [idname] = rowid;
				} Else if (ind.id! == $ TpidPrefix + tmp [idname]) {
					/ / Renomear rowid
					. var oldid = $ jgrid.stripPref ($ tpidPrefix, rowid);
					if ($ tp_index [oldid]! == indefinido) {
						$ Tp_index [tmp [idname]] = $ tp_index [oldid];
						excluir $ tp_index [oldid];
					}
					rowid = $ tpidPrefix + tmp [idname];
					. $ (Ind) attr ("id", rowid);
					if ($ tpselrow === oldRowId) {
						$ Tpselrow = rowid;
					}
					if ($. isArray ($ tpselarrrow)) {
						var i = $ inArray (oldRowId, $ tpselarrrow).;
						if (i> = 0) {
							$ Tpselarrrow [i] = rowid;
						}
					}
					if ($ tpmultiselect) {
						var newCboxId = "jqg_" + $ TPID + "_" + rowid;
						$ ("Input.cbox", ind)
							. Attr ("id", newCboxId)
							. Attr ("nome", newCboxId);
					}
					/ / TODO: para testar o caso de colunas congeladas
				}
				if ($ tpinlineData === indefinido) {$ tpinlineData = {};}
				. tmp = $ estender ({}, tmp, $ tpinlineData, o.extraparam);
			}
			if (o.url === 'clientArray') {
				. tmp = $ estender ({}, tmp, tmp2);
				if ($ tpautoencode) {
					$. Cada (tmp, function (n, v) {
						. tmp [n] = $ jgrid.htmlDecode (v);
					});
				}
				var k, resp = $ ($ t) jqGrid ("setRowData", rowid, tmp).;
				. $ (Ind) attr ("editável", "0");
				for (k = 0; k <$ tpsavedRow.length; k + +) {
					if (String ($ tpsavedRow [k] id) === String (oldRowId).) {fr = k; break;}
				}
				if (fr> = 0) {$ tpsavedRow.splice (fr, 1);}
				. $ ($ T) triggerHandler ("jqGridInlineAfterSaveRow" [rowid, resp, tmp, o]);
				Se {o.aftersavefunc.call ($ t, rowid, resp, o);} ($ isFunction (o.aftersavefunc).)
				sucesso = true;
				.. $ (Ind) removeClass ("jqgrid-new-linha") desvincular ("KeyDown");
			} Else {
				. $ (". # Lui_" + $ jgrid.jqID ($ TPID)) show ();
				. tmp3 = $ estender ({}, tmp, tmp3);
				. tmp3 [idname] = $ jgrid.stripPref ($ tpidPrefix, tmp3 [idname]);
				$. Ajax ($. Estender ({
					url: o.url,
					dados:. $ isFunction ($ tpserializeRowData)? $ TpserializeRowData.call ($ t, tmp3): tmp3,
					digite: o.mtype,
					async: false, / /!?
					completa: function (res, status) {
						. $ (". # Lui_" + $ jgrid.jqID ($ TPID)) hide ();
						if (status === "sucesso") {
							var ret = true, sucret, k;
							. sucret = $ ($ t) triggerHandler ("jqGridInlineSuccessSaveRow", [res, rowid, o]);
							if ($ isArray (sucret)!). {sucret = [true, tmp];}
							if (sucret [0] && $ isFunction (o.successfunc).) {sucret = o.successfunc.call ($ t, res);}							
							if ($. isArray (sucret)) {
								/ / Esperar array - status, dados, rowid
								ret = sucret [0];
								tmp = sucret [1] | | tmp;
							} Else {
								ret = sucret;
							}
							if (ret === true) {
								if ($ tpautoencode) {
									$. Cada (tmp, function (n, v) {
										. tmp [n] = $ jgrid.htmlDecode (v);
									});
								}
								. tmp = $ estender ({}, tmp, tmp2);
								. $ ($ T) jqGrid ("setRowData", rowid, tmp);
								. $ (Ind) attr ("editável", "0");
								for (k = 0; k <$ tpsavedRow.length; k + +) {
									if (String ($ tpsavedRow [k] id) === String (rowid).) {fr = k; break;}
								}
								if (fr> = 0) {$ tpsavedRow.splice (fr, 1);}
								. $ ($ T) triggerHandler ("jqGridInlineAfterSaveRow" [rowid, res, tmp, o]);
								Se {o.aftersavefunc.call ($ t, rowid, res);} ($ isFunction (o.aftersavefunc).)
								sucesso = true;
								.. $ (Ind) removeClass ("jqgrid-new-linha") desvincular ("KeyDown");
							} Else {
								. $ ($ T) triggerHandler ("jqGridInlineErrorSaveRow" [rowid, res, status, null, o]);
								if ($. isFunction (o.errorfunc)) {
									o.errorfunc.call ($ t, rowid, res, stat, null);
								}
								if (o.restoreAfterError === true) {
									$ ($ T) jqGrid ("restoreRow", rowid, o.afterrestorefunc).;
								}
							}
						}
					},
					erro: function (res, stat, err) {
						. $ (". # Lui_" + $ jgrid.jqID ($ TPID)) hide ();
						. $ ($ T) triggerHandler ("jqGridInlineErrorSaveRow" [rowid, res, stat, err, o]);
						if ($. isFunction (o.errorfunc)) {
							o.errorfunc.call ($ t, rowid, res, stat, err);
						} Else {
							var rT = res.responseText | | res.statusText;
							try {
								.. $ Jgrid.info_dialog ($ jgrid.errors.errcap, '<div class="ui-state-error">' + RT + '</ div>', $ jgrid.edit.bClose, {buttonalign:. direito '});
							} Catch (e) {
								alert (RT);
							}
						}
						if (o.restoreAfterError === true) {
							$ ($ T) jqGrid ("restoreRow", rowid, o.afterrestorefunc).;
						}
					}
				}, $ Jgrid.ajaxOptions, $ tpajaxRowOptions | | {})).;
			}
		}
		retornar com êxito;
	},
	restoreRow: function (rowid, afterrestorefunc) {
		Versões / / modo compatível antigos
		.. var args = $ MakeArray (argumentos) fatia (1), o = {};

		if ($. type (args [0]) === "objeto") {
			o = args [0];
		} Else {
			Se {o.afterrestorefunc = afterrestorefunc;} ($ isFunction (afterrestorefunc).)
		}
		. o = $ estender (true, {}, $ jgrid.inlineEdit, o.);

		/ / Fim compatível

		voltar this.each (function () {
			var $ t = isso, fr, ind, ares = {}, k;
			if ($ t.grid!) {return;}
			ind = $ ($ t) jqGrid ("getInd", rowid, true).;
			if (ind === false) {return;}
			var bfcr = $. isFunction (o.beforeCancelRow)? o.beforeCancelRow.call ($ t, cancelPrm, sr): undefined;
			if (bfcr === indefinido) {
				bfcr = true;
			}
			Se {return;} (bfcr!)
			for (k = 0; k <$ tpsavedRow.length; k + +) {
				if (String ($ tpsavedRow [k] id) === String (rowid).) {fr = k; break;}
			}
			if (fr> = 0) {
				if ($. isFunction ($. fn.datepicker)) {
					try {
						. $ (". Input.hasDatepicker", "#" + $ jgrid.jqID (ind.id)) datepicker ('esconder');
					} Catch (e) {}
				}
				$. Cada ($ tpcolModel, function () {
					if (this.editable === verdadeiro && $ tpsavedRow [fr]. hasOwnProperty (this.name)) {
						ares [this.name] = $ tpsavedRow [fr] [this.name];
					}
				});
				. $ ($ T) jqGrid ("setRowData", rowid, ares);
				. $ (Ind) attr ("editável", "0") desvincular ("KeyDown").;
				$ TpsavedRow.splice (fr, 1);
				if ($ ("#" + $. jgrid.jqID (rowid), "#" + $. jgrid.jqID ($ TPID)). hasClass ("jqgrid-new-linha")) {
					setTimeout (function () {
						$ ($ T) jqGrid ("delRowData", rowid).;
						$ ($ T) jqGrid ('showAddEditButtons').;
					}, 0);
				}
			}
			. $ ($ T) triggerHandler ("jqGridInlineAfterRestoreRow" [rowid]);
			if ($. isFunction (o.afterrestorefunc))
			{
				o.afterrestorefunc.call ($ t, rowid);
			}
		});
	},
	addRow: function (p) {
		p = $. estender (true, {
			rowID: null,
			initdata: {},
			posição: "em primeiro lugar",
			useDefValues: verdadeiro,
			useFormatter: false,
			addRowParams: {extraparam: {}}
		}, P | | {});
		voltar this.each (function () {
			Se {return;} (this.grid!)
			var $ t = this;
			var BFAR = $. isFunction (p.beforeAddRow)? p.beforeAddRow.call ($ t, p.addRowParams): undefined;
			if (BFAR === indefinido) {
				BFAR = true;
			}
			Se {return;} (BFAR!)
			p.rowID = $. isFunction (p.rowID)? p.rowID.call ($ t, p): ((p.rowID = null) p.rowID:?. $ jgrid.randId ());
			if (p.useDefValues ​​=== true) {
				$ ($ TpcolModel) cada (função. () {
					if (this.editoptions && this.editoptions.defaultValue) {
						var opt = this.editoptions.defaultValue,
						tmp = $. isFunction (opt)? opt.call ($ t): optar;
						p.initdata [this.name] = tmp;
					}
				});
			}
			. $ ($ T) jqGrid ('addRowData', p.rowID, p.initdata, p.position);
			p.rowID = $ + tpidPrefix p.rowID;
			$ AddClass ("jqgrid-new-linha") ("#" + $ jgrid.jqID (p.rowID), "#" + $ jgrid.jqID ($ TPID)..).;
			if (p.useFormatter) {
				(.. "#" + $ Jgrid.jqID (p.rowID) + ". Ui-inline-edit", "#" + $ jgrid.jqID ($ TPID)). $ Clique ();
			} Else {
				opers var = $ tpprmNames,
				oper = opers.oper;
				p.addRowParams.extraparam [oper] = opers.addoper;
				. $ ($ T) jqGrid ('editRow', p.rowID, p.addRowParams);
				$ ($ T) jqGrid ('setSelection', p.rowID).;
			}
		});
	},
	inlineNav: function (elem, o) {
		o = $. estender (true, {
			edit: verdade,
			editicon: "ui-icon-lápis",
			adicionar: true,
			AddIcon: "ui-icon-plus",
			salvar: true,
			saveicon: "ui-icon-disk",
			cancelar: true,
			cancelicon: "ui-icon-cancelar",
			addParams: {addRowParams: {extraparam: {}}},
			editParams: {},
			restoreAfterSelect: true
		}, $ Jgrid.nav, o | | {}).;
		voltar this.each (function () {
			Se {return;} (this.grid!)
			var $ t = isso, onSelect, gid = $ jgrid.jqID ($ TPID).;
			$ Tp_inlinenav = true;
			/ / Detectar a coluna formatactions
			if (o.addParams.useFormatter === true) {
				var cm = $ tpcolModel, i;
				for (i = 0; i <cm.length; i + +) {
					if (cm [i]. formatador && cm [i]. === formatador "ações") {
						if (cm [i]. formatoptions) {
							defaults var = {
								chaves: false,
								onedit: null,
								onSuccess: null,
								afterSave: null,
								onError: null,
								afterRestore: null,
								extraparam: {},
								url: null
							},
							. ap = $ estender (padrões, cm [i] formatoptions.);
							o.addParams.addRowParams = {
								"chaves": ap.keys,
								"Oneditfunc": ap.onEdit,
								"Successfunc": ap.onSuccess,
								"URL": ap.url,
								"Extraparam": ap.extraparam,
								"Aftersavefunc": ap.afterSave,
								"Errorfunc": ap.onError,
								"Afterrestorefunc": ap.afterRestore
							};
						}
						break;
					}
				}
			}
			if (o.add) {
				$ ($ T). JqGrid ('navButtonAdd', elem, {
					legenda: o.addtext,
					Título: o.addtitle,
					buttonicon: o.addicon,
					ID: $ TPID + "_iladd",
					onClickButton: function () {
						$ ($ T) jqGrid ('addRow', o.addParams).;
						if (o.addParams.useFormatter!) {
							$ ("#" + + GID "_ilsave") removeClass ('ui-state-deficientes ").;
							$ ("#" + + GID "_ilcancel") removeClass ('ui-state-deficientes ").;
							$ ("#" + + GID "_iladd") addClass ('ui-state-deficientes ").;
							$ ("#" + + GID "_iledit") addClass ('ui-state-deficientes ").;
						}
					}
				});
			}
			if (o.edit) {
				$ ($ T). JqGrid ('navButtonAdd', elem, {
					legenda: o.edittext,
					Título: o.edittitle,
					buttonicon: o.editicon,
					ID: $ TPID + "_iledit",
					onClickButton: function () {
						. var sr = $ ($ t) jqGrid ('getGridParam', 'selrow');
						if (sr) {
							. $ ($ T) jqGrid ('editRow', sr, o.editParams);
							$ ("#" + + GID "_ilsave") removeClass ('ui-state-deficientes ").;
							$ ("#" + + GID "_ilcancel") removeClass ('ui-state-deficientes ").;
							$ ("#" + + GID "_iladd") addClass ('ui-state-deficientes ").;
							$ ("#" + + GID "_iledit") addClass ('ui-state-deficientes ").;
						} Else {
							Jgrid.viewModal $ ("# alertmod", {gbox: "# gbox_" + GID, jqm: true});.. $ ("# Jqg_alrt") foco ();							
						}
					}
				});
			}
			if (o.save) {
				$ ($ T). JqGrid ('navButtonAdd', elem, {
					legenda: o.savetext | |'',
					Título: o.savetitle | | 'Salvar linha',
					buttonicon: o.saveicon,
					ID: $ TPID + "_ilsave",
					onClickButton: function () {
						var sr = $ tpsavedRow [0] id.;
						if (sr) {
							opers var = $ tpprmNames,
							oper = opers.oper, tmpParams = {};
							if ($ ("#" + $. jgrid.jqID (sr), "#" + GID). hasClass ("jqgrid-new-linha")) {
								o.addParams.addRowParams.extraparam [oper] = opers.addoper;
								tmpParams = o.addParams.addRowParams;
							} Else {
								if (o.editParams.extraparam!) {
									o.editParams.extraparam = {};
								}
								o.editParams.extraparam [oper] = opers.editoper;
								tmpParams = o.editParams;
							}
							if ($ ($ t). jqGrid ('saveRow', sr, tmpParams)) {
								$ ($ T) jqGrid ('showAddEditButtons').;
							}
						} Else {
							Jgrid.viewModal $ ("# alertmod", {gbox: "# gbox_" + GID, jqm: true});.. $ ("# Jqg_alrt") foco ();							
						}
					}
				});
				$ ("#" + + GID "_ilsave") addClass ('ui-state-deficientes ").;
			}
			if (o.cancel) {
				$ ($ T). JqGrid ('navButtonAdd', elem, {
					legenda: o.canceltext | |'',
					Título: o.canceltitle | | 'Cancelar edição row',
					buttonicon: o.cancelicon,
					ID: $ TPID + "_ilcancel",
					onClickButton: function () {
						. var sr = $ tpsavedRow [0] id, cancelPrm = {};
						if (sr) {
							if ($ ("#" + $. jgrid.jqID (sr), "#" + GID). hasClass ("jqgrid-new-linha")) {
								cancelPrm = o.addParams.addRowParams;
							} Else {
								cancelPrm = o.editParams;
							}
							$ ($ T) jqGrid ('restoreRow', sr, cancelPrm).;
							$ ($ T) jqGrid ('showAddEditButtons').;
						} Else {
							Jgrid.viewModal $ ("# alertmod", {gbox: "# gbox_" + GID, jqm: true});.. $ ("# Jqg_alrt") foco ();							
						}
					}
				});
				$ ("#" + + GID "_ilcancel") addClass ('ui-state-deficientes ").;
			}
			if (o.restoreAfterSelect === true) {
				if ($. isFunction ($ tpbeforeSelectRow)) {
					onSelect = $ tpbeforeSelectRow;
				} Else {
					onSelect = false;
				}
				$ TpbeforeSelectRow = function (id, status) {
					var ret = true;
					if ($ tpsavedRow.length> 0 && $ tp_inlinenav === verdadeiro && (id! == $ tpselrow && $ tpselrow! == null)) {
						if ($ tpselrow === o.addParams.rowID) {
							$ ($ T) jqGrid ('delRowData', $ tpselrow).;
						} Else {
							. $ ($ T) jqGrid ('restoreRow', $ tpselrow, o.editParams);
						}
						$ ($ T) jqGrid ('showAddEditButtons').;
					}
					if (onSelect) {
						ret = onSelect.call ($ t, id, status);
					}
					voltar ret;
				};
			}

		});
	},
	showAddEditButtons: function () {
		voltar this.each (function () {
			Se {return;} (this.grid!)
			. var gid = $ jgrid.jqID (this.p.id);
			$ ("#" + + GID "_ilsave") addClass ('ui-state-deficientes ").;
			$ ("#" + + GID "_ilcancel") addClass ('ui-state-deficientes ").;
			. $ ("#" + + GID "_iladd") removeClass ('ui-state-deficientes ");
			$ ("#" + + GID "_iledit") removeClass ('ui-state-deficientes ").;
		});
	}
/ / Fim da linha de edição
});
}) (JQuery);
/ * Jshint eqeqeq: false * /
/ * JQuery globais * /
(Function ($) {
/ *
**
 * Extensão jqGrid para cellediting Data Grid
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/ 
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
** / 
/ **
 * Todos os eventos e opções aqui são aded anonynous e não na grade de base
 * Desde que a matriz é grande. Aqui está a ordem de execução.
 * A partir deste ponto, usamos jQuery isFunction
 * FormatCell
 * BeforeEditCell,
 * OnSelectCell (usado somente para cels não modificável)
 * AfterEditCell,
 * BeforeSaveCell, (chamado antes da validação dos valores, se houver)
 * BeforeSubmitCell (se cellsubmit remoto (ajax))
 * AfterSubmitCell (se cellsubmit remoto (ajax)),
 * AfterSaveCell,
 * ErrorCell,
 * SerializeCellData - novo
 * Opções
 * Cellsubmit (remoto, clientArray) (adicionado em opções de grade)
 * Cellurl
 * ajaxCellOptions
** /
"Use strict";
$. Jgrid.extend ({
	editCell: function (iRow, iCol, ed) {
		voltar this.each (function () {
			var $ t = isso, nm, tmp, cc, cm;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			iCol = parseInt (iCol, 10);
			/ / Seleccionar a linha que pode ser usado para outros métodos
			. $ Tpselrow = $ t.rows [iRow] id;
			if ($ tpknv!) {$ ($ t) jqGrid ("GridNav");.}
			/ / Verifique se já editado celular
			if ($ tpsavedRow.length> 0) {
				/ / Impedir segundo clique nesse campo e permitir que seleciona
				if (ed === true) {
					if (iRow == $ tpiRow && iCol == $ tpiCol) {
						retorno;
					}
				}
				/ / Salva o celular
				. $ ($ T) jqGrid (". SaveCell", $ tpsavedRow [0] id, $ tpsavedRow [0] ic.);
			} Else {
				window.setTimeout (function () {$ ("#" + $ jgrid.jqID ($ tpknv)) attr ("tabindex", "-1") foco ();...}, 0);
			}
			cm = $ tpcolModel [iCol];
			nm = cm.name;
			if (nm === 'subgrid' | | nm === 'cb' | | nm === 'rn') {return;}
			cc = $ ("td: eq (" + iCol + ")", $ t.rows [iRow]);
			if (cm.editable === verdadeiro && ed === verdadeiro &&! cc.hasClass ("não-célula editável")) {
				if (parseInt ($ tpiCol, 10)> = 0 && parseInt ($ tpiRow, 10)> = 0) {
					$ ("Td: eq (" + $ tpiCol + ")", $ t.rows [$]) tpiRow removeClass ("célula de edição ui-state-destaque"),.
					. $ ($ T.rows [$ tpiRow]) removeClass ("selecionado fileiras ui-state-foco");
				}
				$ (Cc) addClass ("célula de edição ui-state-destaque").;
				. $ ($ T.rows [iRow]) addClass ("selecionado fileiras ui-state-foco");
				try {
					. tmp = $ unformat.call ($ t, cc, {RowId: $ t.rows [iRow] id, colModel:. cm}, iCol);
				} Catch (_) {
					tmp = (cm.edittype && cm.edittype === 'textarea')? . $ (Cc) text (): $. (Cc) html ();
				}
				if ($ tpautoencode) {tmp = $ jgrid.htmlDecode (tmp);.}
				if (cm.edittype!) {cm.edittype = "text";}
				$ TpsavedRow.push ({id: iRow, ic: iCol, name: nm, v: tmp});
				if (tmp === "" | | tmp === "" | | (tmp.length === 1 && tmp.charCodeAt (0) === 160)) {tmp ='' ;}
				if ($. isFunction ($ tpformatCell)) {
					var tmp2 = $ tpformatCell.call ($ t, $ t.rows [iRow] id, nm, tmp, iRow, iCol.);
					if (tmp2 == indefinido!) {tmp = tmp2;}
				}
				. $ ($ T) triggerHandler ("jqGridBeforeEditCell" [$ t.rows [iRow] id, nm, tmp, iRow, iCol.]);
				if ($. isFunction ($ tpbeforeEditCell)) {
					$ TpbeforeEditCell.call (. $ T, $ t.rows [iRow] id, nm, tmp, iRow, iCol);
				}
				. var opt = $ estender ({}, cm.editoptions | | {}, {id: iRow + "_" + nm, name: nm});
				var elc = | | {}));
				. $ (Cc) html ("").. Anexar (ELC) attr ("tabindex", "0");
				$ Jgrid.bindEv.call ($ t, elc, opt).;
				window.setTimeout (function () {$ (ELC) foco ();.}, 0);
				$ ("Input, select, textarea", cc). Bind ("KeyDown", function (e) {
					if (e.KeyCode === 27) {
						if ($ ("input.hasDatepicker", cc). comprimento> 0) {
							if (". ui-datepicker". $ () é (": hidden")) {. $ ($ t) jqGrid ("restoreCell", iRow, iCol);}
							else {$ ("input.hasDatepicker", cc) datepicker ('esconder');.}
						} Else {
							. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
						}
					} / / ESC
					if (=== e.KeyCode 13) {
						. $ ($ T) jqGrid ("saveCell", iRow, iCol);
						/ / Previne ação padrão
						return false;
					} / / Enter
					if (e.KeyCode === 9) {
						if (! $ t.grid.hDiv.loading) {
							if (e.shiftKey) {$ ($ t) jqGrid ("prevCell", iRow, iCol);.} / / Shift Tab
							else {. $ ($ t) jqGrid ("nextCell", iRow, iCol);} / / Tab
						} Else {
							return false;
						}
					}
					e.stopPropagation ();
				});
				. $ ($ T) triggerHandler ("jqGridAfterEditCell" [$ t.rows [iRow] id, nm, tmp, iRow, iCol.]);
				if ($. isFunction ($ tpafterEditCell)) {
					$ TpafterEditCell.call (. $ T, $ t.rows [iRow] id, nm, tmp, iRow, iCol);
				}
			} Else {
				if (parseInt ($ tpiCol, 10)> = 0 && parseInt ($ tpiRow, 10)> = 0) {
					$ ("Td: eq (" + $ tpiCol + ")", $ t.rows [$]) tpiRow removeClass ("célula de edição ui-state-destaque"),.
					. $ ($ T.rows [$ tpiRow]) removeClass ("selecionado fileiras ui-state-foco");
				}
				cc.addClass ("célula de edição ui-state-destaque");
				. $ ($ T.rows [iRow]) addClass ("selecionado fileiras ui-state-foco");
				tmp = cc.html () replace (/ \ \ ;/ ig,'').;
				. $ ($ T) triggerHandler ("jqGridSelectCell" [$ t.rows [iRow] id, nm, tmp, iRow, iCol.]);
				if ($. isFunction ($ tponSelectCell)) {
					$ TponSelectCell.call (. $ T, $ t.rows [iRow] id, nm, tmp, iRow, iCol);
				}
			}
			$ TpiCol = iCol; $ tpiRow = iRow;
		});
	},
	saveCell: function (iRow, iCol) {
		voltar this.each (function () {
			var $ t = isso, fr;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			if ($ tpsavedRow.length> = 1) {fr = 0;} else {fr = null;} 
			if (fr! == null) {
				var cc = $ ("td: eq (" + iCol + ")", $ t.rows [iRow]), v, v2,
				. cm = $ tpcolModel [iCol], nm = cm.name, nmjq = $ jgrid.jqID (nm);
				switch (cm.edittype) {
					caso ", selecione":
						if (cm.editoptions.multiple!) {
							v = $ ("#" + iRow + "_" + nmjq + "opção: selecionado", $ t.rows [iRow]). val ();
							v2 = $ ("#" + iRow + "_" + nmjq + "opção: selecionado", $ t.rows [iRow]). texto ();
						} Else {
							var sel = $ ("#" + iRow + "_" + nmjq, $ t.rows [iRow]), SelectedText = [];
							. v = $ (sel) val ();
							if (v) {v.join (",");} else {v = "";}
							$ ("Opção: selecionado", sel). Cada (
								função (i, selecionado) {
									. SelectedText [i] = $ (selecionado) text ();
								}
							);
							v2 = selectedText.join (",");
						}
						if (cm.formatter) {v2 = v;}
						break;
					caso "checkbox":
						var cbv = ["Sim", "Não"];
						if () {cm.editoptions
							cbv = cm.editoptions.value.split (":");
						}
						v = $ ("#" + iRow + "_" + nmjq, $ t.rows [iRow]) é. (": checked")? cbv [0]: cbv [1];
						v2 = v;
						break;
					caso "password":
					caso "text":
					case "textarea":
					case "botão":
						v = $ ("#" + iRow + "_" + nmjq, $ t.rows [iRow]) val ().;
						v2 = v;
						break;
					caso 'custom':
						try {
							if ($ cm.editoptions &&. isFunction (cm.editoptions.custom_value)) {
								v = cm.editoptions.custom_value.call ($ t, $ (, cc), "ficar" customelement. ");
								if (v === indefinido) {throw "e2";} else {v2 = v;}
							} Else {throw "e1";}
						} Catch (e) {
							if (e === "e1") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_value '"+ $. jgrid.edit.msg.nodefined, $. jgrid.edit.bClose) ;}
							if (e === "e2") {$. jgrid.info_dialog ($. jgrid.errors.errcap, "função" custom_value '"+ $. jgrid.edit.msg.novalue, $. jgrid.edit.bClose) ;}
							else {$ jgrid.info_dialog ($ jgrid.errors.errcap, e.Message, $ jgrid.edit.bClose..);.}
						}
						break;
				}
				/ / A abordagem comum é se nada mudou não fazem nada
				if (v2! == $ tpsavedRow [fr]. v) {
					var vvv = $ ($ t) triggerHandler ("jqGridBeforeSaveCell" [$ t.rows [iRow] id, nm, v, iRow, iCol.]).;
					if (VVV) {v = vvv; v2 = vvv;}
					if ($. isFunction ($ tpbeforeSaveCell)) {
						var vv = $ tpbeforeSaveCell.call ($ t, $ t.rows [iRow] id, nm, v, iRow, iCol.);
						if (vv) {v = vv; v2 = vv;}
					}
					. var cv = $ jgrid.checkValues.call ($ t, v, iCol);
					if (cv [0] === true) {
						var addpost = $ ($ t) triggerHandler ("jqGridBeforeSubmitCell" [$ t.rows [iRow] id, nm, v, iRow, iCol.]) | | {}.;
						if ($. isFunction ($ tpbeforeSubmitCell)) {
							addpost = $ tpbeforeSubmitCell.call ($ t, $ t.rows [iRow] id, nm, v, iRow, iCol.);
							Se {addpost = {};} (addpost!)
						}
						if (. $ ("input.hasDatepicker", cc) comprimento> 0) {$ ("input.hasDatepicker", cc) datepicker ('esconder');.}
						if ($ tpcellsubmit === 'remoto') {
							if ($ tpcellurl) {
								var postdata = {};
								if ($ tpautoencode) {$ v = jgrid.htmlEncode (v),.}
								postdata [nm] = v;
								var idname, oper, opers;
								opers = $ tpprmNames;
								idname = opers.id;
								oper = opers.oper;
								. postdata [idname] = $ jgrid.stripPref ($ tpidPrefix, $ t.rows [iRow] id.);
								postdata [oper] = opers.editoper;
								. postdata = $ estender (addpost, postdata);
								. $ (". # Lui_" + $ jgrid.jqID ($ TPID)) show ();
								$ T.grid.hDiv.loading = true;
								$. Ajax ($. Estender ({
									url: $ tpcellurl,
									dados:. $ isFunction ($ tpserializeCellData)? $ TpserializeCellData.call ($ t, postdata): postdata,
									digite: "POST",
									completar: function (resultado, status) {
										. $ ("# Lui_" + $ TPID) hide ();
										$ T.grid.hDiv.loading = false;
										if (status === 'sucesso') {
											. var ret = $ ($ t) triggerHandler ("jqGridAfterSubmitCell" [$ t, resultado, postdata.id, nm, v, iRow, iCol]) | | [true,''];
											if (ret [0] === verdadeiro && $. isFunction ($ tpafterSubmitCell)) {
												ret = $ tpafterSubmitCell.call ($ t, resultado, postdata.id, nm, v, iRow, iCol);
											}
											if (ret [0] === true) {
												. $ (Cc) empty ();
												. $ ($ T) jqGrid ("setCell", $ t.rows [iRow] id, iCol, v2, falso, falso, verdadeiro.);
												. $ (Cc) addClass ("célula sujo");
												. $ ($ T.rows [iRow]) addClass ("editado");
												. $ ($ T) triggerHandler ("jqGridAfterSaveCell" [$ t.rows [iRow] id, nm, v, iRow, iCol.]);
												if ($. isFunction ($ tpafterSaveCell)) {
													$ TpafterSaveCell.call (. $ T, $ t.rows [iRow] id, nm, v, iRow, iCol);
												}
												$ TpsavedRow.splice (0,1);
											} Else {
												$ Jgrid.info_dialog ($ jgrid.errors.errcap, ret [1], $ jgrid.edit.bClose..).;
												. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
											}
										}
									},
									erro: function (res, stat, err) {
										. $ (". # Lui_" + $ jgrid.jqID ($ TPID)) hide ();
										$ T.grid.hDiv.loading = false;
										. $ ($ T) triggerHandler ("jqGridErrorCell" [res, stat, err]);
										if ($. isFunction ($ tperrorCell)) {
											$ TperrorCell.call ($ t, res, stat, err);
											. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
										} Else {
											. $ Jgrid.info_dialog (.. $ Jgrid.errors.errcap, res.status + ":" + res.statusText + "<br/>" + status, $ jgrid.edit.bClose);
											. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
										}
									}
								}, $ Jgrid.ajaxOptions, $ tpajaxCellOptions | | {})).;
							} Else {
								try {
									$ Jgrid.info_dialog ($ jgrid.errors.errcap, $ jgrid.errors.nourl, $ jgrid.edit.bClose...).;
									. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
								} Catch (e) {}
							}
						}
						if ($ tpcellsubmit === 'clientArray') {
							. $ (Cc) empty ();
							. $ ($ T) jqGrid ("setCell", $ t.rows [iRow] id, iCol, v2, falso, falso, verdadeiro.);
							. $ (Cc) addClass ("célula sujo");
							. $ ($ T.rows [iRow]) addClass ("editado");
							. $ ($ T) triggerHandler ("jqGridAfterSaveCell" [$ t.rows [iRow] id, nm, v, iRow, iCol.]);
							if ($. isFunction ($ tpafterSaveCell)) {
								$ TpafterSaveCell.call (. $ T, $ t.rows [iRow] id, nm, v, iRow, iCol);
							}
							$ TpsavedRow.splice (0,1);
						}
					} Else {
						try {
							window.setTimeout (function () {... $ jgrid.info_dialog ($ jgrid.errors.errcap, v + "" + cv [1], $ jgrid.edit.bClose);}, 100);
							. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
						} Catch (e) {}
					}
				} Else {
					. $ ($ T) jqGrid ("restoreCell", iRow, iCol);
				}
			}
			window.setTimeout (function () {$ ("#" + $ jgrid.jqID ($ tpknv)) attr ("tabindex", "-1") foco ();...}, 0);
		});
	},
	restoreCell: function (iRow, iCol) {
		voltar this.each (function () {
			var $ t = isso, fr;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			if ($ tpsavedRow.length> = 1) {fr = 0;} else {fr = null;}
			if (fr! == null) {
				var cc = $ ("td: eq (" + iCol + ")", $ t.rows [iRow]);
				/ / Fix datepicker
				if ($. isFunction ($. fn.datepicker)) {
					try {
						$ ("Input.hasDatepicker", cc) datepicker ('esconder').;
					} Catch (e) {}
				}
				.. $ (Cc) empty () attr ("tabindex", "-1");
				. $ ($ T) jqGrid ("setCell", $ t.rows [iRow] id, iCol, $ tpsavedRow [fr] v, falso, falso, verdadeiro..);
				. $ ($ T) triggerHandler ("jqGridAfterRestoreCell" [$ t.rows [iRow] id, $ tpsavedRow [fr] v, iRow, iCol..]);
				if ($. isFunction ($ tpafterRestoreCell)) {
					$ TpafterRestoreCell.call ($ t, $ t.rows [iRow] id, $ tpsavedRow [fr] v, iRow, iCol..);
				}				
				$ TpsavedRow.splice (0,1);
			}
			window.setTimeout (function () {.. $ ("#" + $ tpknv) attr ("tabindex", "-1") foco ();}, 0);
		});
	},
	nextCell: function (iRow, iCol) {
		voltar this.each (function () {
			var $ t = isso, nCol = false, i;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			/ / Tenta encontrar próxima célula editável
			for (i = iCol +1; i <$ tpcolModel.length; i + +) {
				if ($ tpcolModel [i]. editável === true) {
					nCol = i; break;
				}
			}
			if (nCol! == false) {
				. $ ($ T) jqGrid ("editCell", iRow, nCol, true);
			} Else {
				if ($ tpsavedRow.length> 0) {
					. $ ($ T) jqGrid ("saveCell", iRow, iCol);
				}
			}
		});
	},
	prevCell: function (iRow, iCol) {
		voltar this.each (function () {
			var $ t = isso, nCol = false, i;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			/ / Tenta encontrar próxima célula editável
			for (i = iCol-1; i> = 0; i -) {
				if ($ tpcolModel [i]. editável === true) {
					nCol = i; break;
				}
			}
			if (nCol! == false) {
				. $ ($ T) jqGrid ("editCell", iRow, nCol, true);
			} Else {
				if ($ tpsavedRow.length> 0) {
					. $ ($ T) jqGrid ("saveCell", iRow, iCol);
				}
			}
		});
	},
	GridNav: function () {
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			/ / Truque para processar keydown em elementos não entrada
			Tpknv $ = $ TPID + "_kn";
			estilo seleção var = $ ("<div style='position:fixed;top:0px;width:1px;height:1px;' tabindex='0'> <div tabindex = '-1' = 'width: 1px; altura : 1px; 'id =' "+ $ tpknv +" '> </ div> </ div> "),
			i, KDIR;
			função scrollGrid (iR, iC, tp) {
				if (tp.substr (0,1) === 'v') {
					var pc = $ ($ t.grid.bDiv) [0]. clientHeight,
					st = $ ($ t.grid.bDiv) [0]. scrollTop,
					NROT = $ t.rows [IR]. offsetTop + $ t.rows [IR]. clientWidth,
					Prot = $ t.rows [iR] offsetTop.;
					if (tp === 'vd') {
						if (NROT> = ch) {
							.. $ ($ T.grid.bDiv) [0] scrollTop = $ ($ t.grid.bDiv) [0] + $ scrollTop t.rows [iR] clientHeight.;
						}
					}
					if (tp === 'vu') {
						if (PROT <st) {
							... $ ($ T.grid.bDiv) [0] scrollTop = $ ($ t.grid.bDiv) [0] scrollTop - $ t.rows [iR] clientHeight;
						}
					}
				}
				if (tp === 'h') {
					var cw = $ ($ t.grid.bDiv) [0]. clientWidth,
					sl = $ ($ t.grid.bDiv) [0]. ScrollLeft,
					ncol = $ t.rows [IR]. células [iC]. offsetLeft + $ t.rows [IR]. células [iC]. clientHeight,
					PCOL = $ t.rows [IR] células [iC]. offsetLeft.;
					if (ncol> = + parseInt cw (sl, 10)) {
						... $ ($ T.grid.bDiv) [0] ScrollLeft = $ ($ t.grid.bDiv) [0] + $ ScrollLeft t.rows [iR] células [iC] clientHeight.;
					} Else if (PCOL <sl) {
						.... $ ($ T.grid.bDiv) [0] ScrollLeft = $ ($ t.grid.bDiv) [0] ScrollLeft - $ t.rows [iR] células [iC] clientHeight;
					}
				}
			}
			função findNextVisible (iC, ato) {
				var ind, i;
				if (act === 'LFT') {
					ind = iC +1;
					for (i = iC, i> = 0; i -) {
						if ($ tpcolModel [i]. escondido! == true) {
							ind i =;
							break;
						}
					}
				}
				if (act === 'RGT') {
					ind = iC-1;
					for (i = iC, i <$ tpcolModel.length; i + +) {
						if ($ tpcolModel [i]. escondido! == true) {
							ind i =;
							break;
						}						
					}
				}
				voltar ind;
			}

			$ (Seleção) insertBefore ($ t.grid.cDiv).;
			$ ("#" + $ Tpknv)
			. Focus ()
			. Keydown (function (e) {
				KDIR = e.KeyCode;
				if ($ tpdirection === "RTL") {
					if (KDIR === 37) {KDIR = 39;}
					else if (KDIR === 39) {KDIR = 37;}
				}
				switch (KDIR) {
					Caso 38:
						if ($ tpiRow-1> 0) {
							scrollGrid ($ tpiRow-1, $ tpiCol, 'vu');
							$ ($ T) jqGrid ("editCell", $ tpiRow-1, $ tpiCol, false).;
						}
					break;
					caso 40:
						if ($ tpiRow +1 <= $ t.rows.length-1) {
							scrollGrid ($ tpiRow +1, $ tpiCol ", vd ');
							. $ ($ T) jqGrid ("editCell", $ tpiRow +1, $ tpiCol, false);
						}
					break;
					caso 37:
						if ($ tpiCol -1> = 0) {
							i = findNextVisible ($ tpiCol-1, "LFT");
							scrollGrid ($ tpiRow, i, 'h');
							. $ ($ T) jqGrid ("editCell", $ tpiRow, i, false);
						}
					break;
					case 39:
						if ($ tpiCol +1 <= $ tpcolModel.length-1) {
							i = findNextVisible ($ tpiCol +1 ", RGT ');
							scrollGrid ($ tpiRow, i, 'h');
							. $ ($ T) jqGrid ("editCell", $ tpiRow, i, false);
						}
					break;
					caso 13:
						if (parseInt ($ tpiCol, 10)> = 0 && parseInt ($ tpiRow, 10)> = 0) {
							. $ ($ T) jqGrid ("editCell", $ tpiRow, $ tpiCol, true);
						}
					break;
					default:
						return true;
				}
				return false;
			});
		});
	},
	getChangedCells: function (mthd) {
		var ret = [];
		Se {mthd = 'all';} (mthd!)
		this.each (function () {
			var $ t = isso, nm;
			if ($ t.grid | | $ tpcellEdit == true!) {return;}
			$ ($ T.rows). Cada (function (j) {
				res var = {};
				if ($ this (). hasClass ("editado")) {
					$ ('Td', this). Cada (function (i) {
						. nm = $ tpcolModel [i] nome;
						if (nm! == 'cb' && nm! == 'subgrid') {
							if (mthd === 'sujo') {
								if ($ this (). hasClass ('células-sujo')) {
									try {
										. res [nm] = $ unformat.call ($ t, este, {. RowId: $ t.rows [j] id, colModel: $ tpcolModel [i]}, i);
									} Catch (e) {
										. res [nm] = $ jgrid.htmlDecode (. $ (this) html ());
									}
								}
							} Else {
								try {
									. res [nm] = $ unformat.call ($ t, este, {. RowId: $ t.rows [j] id, colModel: $ tpcolModel [i]}, i);
								} Catch (e) {
									. res [nm] = $ jgrid.htmlDecode (. $ (this) html ());
								}
							}
						}
					});
					res.id = this.id;
					ret.push (res);
				}
			});
		});
		voltar ret;
	}
/ / / Edição de célula final
});
}) (JQuery);
/ * Jshint eqeqeq: false * /
/ * JQuery globais * /
(Function ($) {
/ **
 * JqGrid extensão para dados subgrid
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/ 
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
** /
"Use strict";
$. Jgrid.extend ({
setSubGrid: function () {
	voltar this.each (function () {
		var $ t = isso, cm, i,
		suboptions = {
			plusicon: "ui-icon-plus",
			minusicon: "ui-icon-menos",
			OpenIcon: "ui-icon-carat-1-sw",
			expandOnLoad: false,
			delayOnLoad: 50,
			selectOnExpand: false,
			selectOnCollapse: false,
			reloadOnExpand: true
		};
		. $ TpsubGridOptions = $ estender (suboptions, $ tpsubGridOptions | | {});
		TpcolNames.unshift $ ("");
		$ TpcolModel.unshift ({name: 'subgrid, largura: $ $ jgrid.cell_width tpsubGridWidth + $ tpcellLayout: $ tpsubGridWidth, classificável: false, resizable: false, hidedlg: true, busca: false, fixo:.? True});
		cm = $ tpsubGridModel;
		if (cm [0]) {
			. cm [0] align = $ estender ([], cm [0] alinhar | | [].).;
			for (i = 0; i <cm [0] name.length; i + +.) {cm [0] alinhar [i] = cm [0] alinhar [i] | | 'esquerda',..}
		}
	});
},
addSubGridCell: function (pos, iRow) {
	var prp ='', ic, sid;
	this.each (function () {
		prp = this.formatCol (pos, iRow);
		sid = this.p.id;
		ic = this.p.subGridOptions.plusicon;
	});
	voltar "<td role=\"gridcell\" aria-describedby=\""+sid+"_subgrid\" class=\"ui-sgcollapsed sgcollapsed\" "+prp+"> <a style='cursor:pointer;'> <span class='ui-icon "+ic+"'> </ span> </ a> </ td> ";
},
addSubGrid: function (pos, sind) {
	voltar this.each (function () {
		ts var = this;
		Se {return;} (ts.grid!)
		/ / -------------------------
		var subGridCell = function (trdiv, celular, pos)
		{
			. var tddiv = $ ("<td align='"+ts.p.subGridModel[0].align[pos]+"'> </ td>") html (celular);
			. $ (Trdiv) append (tddiv);
		};
		var subGridXml = function (sjxml, sbid) {
			var tddiv, i, sgmap,
			manequim = $ ("<table cellspacing='0' cellpadding='0' border='0'> <tbody> </ tbody> </ table>"),
			trdiv = $ ("<tr> </ tr>");
			for (i = 0; i <ts.p.subGridModel [0] name.length;. i + +) {
				tddiv = $ ("<th class='ui-state-default ui-th-subgrid ui-th-column ui-th-"+ts.p.direction+"'> </ th>");
				. $ (Tddiv) html (. Ts.p.subGridModel [0] nome [i]);
				. $ (Tddiv) largura (. Ts.p.subGridModel [0] largura [i]);
				. $ (Trdiv) append (tddiv);
			}
			. $ (Dummy) append (trdiv);
			if (sjxml) {
				sgmap = ts.p.xmlReader.subgrid;
				$ (Sgmap.root + "" + sgmap.row, sjxml) cada (função. () {
					trdiv = $ ("<tr class='ui-widget-content ui-subtblcell'> </ tr>");
					if (sgmap.repeatitems === true) {
						$ (Sgmap.cell, this). Cada (function (i) {
							subGridCell (trdiv, $ (this) text () | | '', i.);
						});
					} Else {
						var f = ts.p.subGridModel [0] mapeamento | | ts.p.subGridModel [0] nome..;
						se (f) {
							for (i = 0; i <f.length; i + +) {
								subGridCell (trdiv, $ (f [i], this) text () | | '', i.);
							}
						}
					}
					. $ (Dummy) append (trdiv);
				});
			}
			. var pid = $ ("table: em primeiro lugar", ts.grid.bDiv) attr ("id") + "_";
			. $ (. "#" + $ Jgrid.jqID (PID + sbid)) append (simulado);
			ts.grid.hDiv.loading = false;
			(". # Load_" + $ jgrid.jqID (ts.p.id)) $ hide ().;
			return false;
		};
		var subGridJson = function (sjxml, sbid) {
			var tddiv, resultado, i, cur, sgmap, j,
			manequim = $ ("<table cellspacing='0' cellpadding='0' border='0'> <tbody> </ tbody> </ table>"),
			trdiv = $ ("<tr> </ tr>");
			for (i = 0; i <ts.p.subGridModel [0] name.length;. i + +) {
				tddiv = $ ("<th class='ui-state-default ui-th-subgrid ui-th-column ui-th-"+ts.p.direction+"'> </ th>");
				. $ (Tddiv) html (. Ts.p.subGridModel [0] nome [i]);
				. $ (Tddiv) largura (. Ts.p.subGridModel [0] largura [i]);
				. $ (Trdiv) append (tddiv);
			}
			. $ (Dummy) append (trdiv);
			if (sjxml) {
				sgmap = ts.p.jsonReader.subgrid;
				result = $ jgrid.getAccessor (sjxml, sgmap.root).;
				if (resultado! == indefinido) {
					for (i = 0; i <result.length; i + +) {
						cur = resultado [i];
						trdiv = $ ("<tr class='ui-widget-content ui-subtblcell'> </ tr>");
						if (sgmap.repeatitems === true) {
							if (sgmap.cell) {cur = cur [sgmap.cell];}
							for (j = 0; j <cur.length; j + +) {
								subGridCell (trdiv, cur [j] | | ', j);
							}
						} Else {
							var f = ts.p.subGridModel [0] mapeamento | | ts.p.subGridModel [0] nome..;
							if (f.length) {
								for (j = 0; j <f.length; j + +) {
									subGridCell (trdiv, cur [f [j]] | | ', j);
								}
							}
						}
						. $ (Dummy) append (trdiv);
					}
				}
			}
			. var pid = $ ("table: em primeiro lugar", ts.grid.bDiv) attr ("id") + "_";
			. $ (. "#" + $ Jgrid.jqID (PID + sbid)) append (simulado);
			ts.grid.hDiv.loading = false;
			(". # Load_" + $ jgrid.jqID (ts.p.id)) $ hide ().;
			return false;
		};
		var populatesubgrid = function (rd)
		{
			var sid, dp, i, j;
			. sid = $ (rd) attr ("id");
			dp = {nd_: (. new Date () getTime ())};
			dp [ts.p.prmNames.subgridid] = sid;
			if (ts.p.subGridModel [0]!) {return false;}
			if (ts.p.subGridModel [0]. params) {
				for (j = 0; j <ts.p.subGridModel [0] params.length;. j + +) {
					for (i = 0; i <ts.p.colModel.length; i + +) {
						if (ts.p.colModel [i]. === ts.p.subGridModel nome [0]. params [j]) {
							dp [ts.p.colModel [i] nome.] = $.. ("td: eq (" + i + ")," rd) text () replace (/ \ \ ;/ ig,'') ;
						}
					}
				}
			}
			if (ts.grid.hDiv.loading!) {
				ts.grid.hDiv.loading = true;
				. $ (". # Load_" + $ jgrid.jqID (ts.p.id)) show ();
				if (ts.p.subgridtype!) {ts.p.subgridtype = ts.p.datatype;}
				if ($. isFunction (ts.p.subgridtype)) {
					ts.p.subgridtype.call (ts, dp);
				} Else {
					ts.p.subgridtype ts.p.subgridtype.toLowerCase = ();
				}
				switch (ts.p.subgridtype) {
					caso "xml":
					case "json":
					$. Ajax ($. Estender ({
						digite: ts.p.mtype,
						url: ts.p.subGridUrl,
						Tipo de dado: ts.p.subgridtype,
						Dados:. $ isFunction (ts.p.serializeSubGridData)? ts.p.serializeSubGridData.call (ts, dp): dp,
						completa: function (sXML) {
							if (ts.p.subgridtype === "xml") {
								subGridXml (sxml.responseXML, sid);
							} Else {
								subGridJson (. $ jgrid.parse (sxml.responseText), sid);
							}
							sXML = null;
						}
					}, $ Jgrid.ajaxOptions, ts.p.ajaxSubgridOptions | | {})).;
					break;
				}
			}
			return false;
		};
		var _id, pid, atd, NHC = 0, BFSC, r;
		$. Cada (ts.p.colModel, function () {
			if (this.hidden === verdadeiro | | this.name === 'rn' | | this.name === 'cb') {
				NHC + +;
			}
		});
		var len = ts.rows.length, i = 1;
		if (sind! == indefinido && sind> 0) {
			i = sind;
			len = sind +1;
		}
		while (i <len) {
			if ($ (ts.rows [i]). hasClass ('jqgrow')) {
				$ (ts.rows [i]. células [pos]). bind ('click', function () {
					. var tr = $ (this) pai ("tr") [0];
					r = tr.nextSibling;
					if ($ this (). hasClass ("sgcollapsed")) {
						pid = ts.p.id;
						_id = tr.id;
						if (ts.p.subGridOptions.reloadOnExpand === verdadeiro | |!. (ts.p.subGridOptions.reloadOnExpand === false && $ (r) hasClass ('ui-subgrid'))) {
							atd = pos> = 1? "<td Colspan='"+pos+"'> </ td>": "";
							BFSC = $ (ts) triggerHandler ("jqGridSubGridBeforeExpand" [pID + "_" + _id, _id]).;
							BFSC = (BFSC === false | | BFSC === 'stop')? false: true;
							if ($ BFSC &&. isFunction (ts.p.subGridBeforeExpand)) {
								BFSC = ts.p.subGridBeforeExpand.call (ts, o PID + "_" + _id, _id);
							}
							if (BFSC === false) {return false;}
							$ (Tr). Após ("<tr role='row' class='ui-subgrid'>" + + atd "<td class='ui-widget-content subgrid-cell'> <span class =" ui-icon "+ ts.p.subGridOptions.openicon +" '> </ span> </ td> <td colspan =' "+ parseInt (ts.p.colNames.length-1-NHC, 10) +" 'class =' ​​ui -widget-content 'subgrade-data> <div id="+pID+"_"+_id+" class='tablediv'> </ div> </ td> </ tr> ");
							$ (Ts) triggerHandler ("jqGridSubGridRowExpanded" [pID + "_" + _id, _id]).;
							if ($. isFunction (ts.p.subGridRowExpanded)) {
								ts.p.subGridRowExpanded.call (ts, o PID + "_" + _id, _id);
							} Else {
								populatesubgrid (tr);
							}
						} Else {
							. $ (R) show ();
						}
						$ (This). Html ("<a style='cursor:pointer;'> <span class='ui-icon "+ts.p.subGridOptions.minusicon+"'> </ span> </ a>"). removeClass ("sgcollapsed") addClass ("sgexpanded").;
						if (ts.p.subGridOptions.selectOnExpand) {
							$ (Ts) jqGrid ('setSelection' _id).;
						}
					} Else if ($ this (). HasClass ("sgexpanded")) {
						BFSC = $ (ts) triggerHandler ("jqGridSubGridRowColapsed" [pID + "_" + _id, _id]).;
						BFSC = (BFSC === false | | BFSC === 'stop')? false: true;
						_id = tr.id;
						if ($ BFSC &&. isFunction (ts.p.subGridRowColapsed)) {
							BFSC = ts.p.subGridRowColapsed.call (ts, o PID + "_" + _id, _id);
						}
						if (BFSC === false) {return false;}
						if (ts.p.subGridOptions.reloadOnExpand === true) {
							$ (R) remover ("ui-subgrid.").;
						} Else if ($ (r). HasClass ('ui-subgrid')) {/ / revestir de exclusão dinâmica
							. $ (R) esconder ();
						}
						$ (This). Html ("<a style='cursor:pointer;'> <span class='ui-icon "+ts.p.subGridOptions.plusicon+"'> </ span> </ a>"). removeClass ("sgexpanded") addClass ("sgcollapsed").;
						if (ts.p.subGridOptions.selectOnCollapse) {
							$ (Ts) jqGrid ('setSelection' _id).;
						}
					}
					return false;
				});
			}
			i + +;
		}
		if (ts.p.subGridOptions.expandOnLoad === true) {
			$ (Ts.rows). Filtrar ('. Jqgrow'). Cada (function (index, linha) {
				. $ (Row.cells [0]) click ();
			});
		}
		ts.subGridXml = function (xml, sid) {subGridXml (xml, sid);};
		ts.subGridJson = function (json, sid) {subGridJson (json, sid);};
	});
},
expandSubGridRow: function (rowid) {
	voltar this.each (function () {
		var $ t = this;
		if (! $ t.grid && rowid) {return;}
		if ($ tpsubGrid === true) {
			var rc = $ (this) jqGrid ("getInd", rowid, true).;
			if (rc) {
				var SGC = $ ("td.sgcollapsed", rc) [0];
				if (SGC) {
					. $ (SGC) gatilho ("click");
				}
			}
		}
	});
},
collapseSubGridRow: function (rowid) {
	voltar this.each (function () {
		var $ t = this;
		if (! $ t.grid && rowid) {return;}
		if ($ tpsubGrid === true) {
			var rc = $ (this) jqGrid ("getInd", rowid, true).;
			if (rc) {
				var SGC = $ ("td.sgexpanded", rc) [0];
				if (SGC) {
					. $ (SGC) gatilho ("click");
				}
			}
		}
	});
},
toggleSubGridRow: function (rowid) {
	voltar this.each (function () {
		var $ t = this;
		if (! $ t.grid && rowid) {return;}
		if ($ tpsubGrid === true) {
			var rc = $ (this) jqGrid ("getInd", rowid, true).;
			if (rc) {
				var SGC = $ ("td.sgcollapsed", rc) [0];
				if (SGC) {
					. $ (SGC) gatilho ("click");
				} Else {
					SGC = $ ("td.sgexpanded", rc) [0];
					if (SGC) {
						. $ (SGC) gatilho ("click");
					}
				}
			}
		}
	});
}
});
}) (JQuery);
/ **
 * JqGrid extensão - árvore de grade
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl.html
** /

/ * Jshint eqeqeq: false * /
/ * JQuery globais * /
(Function ($) {
"Use strict";
$. Jgrid.extend ({
	setTreeNode: function (i, len) {
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			var expCol = $ tpexpColInd,
			expandida = $ tptreeReader.expanded_field,
			IsLeaf = $ tptreeReader.leaf_field,
			level = $ tptreeReader.level_field,
			ícone = $ tptreeReader.icon_field,
			carregado = $ tptreeReader.loaded, LFT, RGT, curLevel, ident, lftpos, Twrap,
			ldat, LF;
			while (i <len) {
				. var ind = $ jgrid.stripPref ($ tpidPrefix, $ t.rows [i] ID.), dinD = $ tp_index [ind], expansão;
				ldat = $ tpdata [dinD];
				. / / $ T.rows [i] level = ldat [nível];
				if ($ tptreeGridModel === 'aninhado') {
					if (! ldat [IsLeaf]) {
					LFT = parseInt (ldat [$ tptreeReader.left_field], 10);
					RGT = parseInt (ldat [$ tptreeReader.right_field], 10);
					/ / NS Modelo
						ldat [IsLeaf] = (RGT === LFT +1)? 'True': 'false';
						$ t.rows [i] [células $ tp_treeleafpos] innerHTML = ldat [IsLeaf].;.
					}
				}
				/ / Else {
					/ / = Row.parent_id estr [$ tptreeReader.parent_id_field];
				/ /}
				curLevel = parseInt (ldat [nível], 10);
				if ($ tptree_root_level === 0) {
					ident = curLevel +1;
					lftpos = curLevel;
				} Else {
					ident = curLevel;
					lftpos curLevel = -1;
				}
				Twrap = "<div class='tree-wrap tree-wrap-"+$tpdirection+"' style='width:"+(ident*18)+"px;'>";
				Twrap + = "<div style = '" + ($ tpdirection === "RTL" "certo:": "Esquerda:") + (lftpos * 18) + "px;' class =" ui-icon ";


				if (ldat [carregadas]! == undefined) {
					if (ldat [carregadas] === "verdadeiro" | | ldat [carregadas] === true) {
						ldat [carregadas] = true;
					} Else {
						ldat [carregadas] = false;
					}
				}
				if (ldat [IsLeaf] === "verdadeiro" | | ldat [IsLeaf] === true) {
					(! (ldat [ícone] == indefinido && ldat [ícone] == "") ldat [ícone]?: $ tptreeIcons.leaf) + "Twrap + = treeclick árvore de folhas";
					ldat [IsLeaf] = true;
					lf = "folha";
				} Else {
					ldat [IsLeaf] = false;
					lf = "";
				}
				ldat [expandida] = ((ldat [expandida] === "verdadeiro" | | ldat [expandida] === true) verdadeiro: false) && (ldat [carregadas] | | ldat [carregadas] === indefinido) ;
				if (ldat [expandida] === false) {
					Twrap + = (? (ldat [IsLeaf] === true) "'": $ tptreeIcons.plus + "árvore-plus treeclick'");
				} Else {
					Twrap + = ((ldat [IsLeaf] === true) "'": $ tptreeIcons.minus + "árvore-minus treeclick'?");
				}
				
				Twrap + = "> </ div> </ div>";
				.. $ (. $ T.rows [i] células [expCol]) wrapInner ("<span class='cell-wrapper"+lf+"'> </ span>") preceder (Twrap);

				if (curLevel! == parseInt ($ tptree_root_level, 10)) {
					var pn = $ ($ t) jqGrid ('getNodeParent', ldat).;
					expansão = pn && pn.hasOwnProperty (expandido)? pn [expandida]: true;
					if (expan!) {
						. $ ($ T.rows [i]) css ("display", "none");
					}
				}
				$ ($ T.rows [i]. Células [expCol])
					. Encontrar ("div.treeclick")
					. Bind ("click", function (e) {
						var target = e.target | | e.srcElement,
						ind2 = $. jgrid.stripPref ($ tpidPrefix, $ (alvo, $ t.rows). mais próximo ("tr.jqgrow") [0]. id),
						pos = $ tp_index [ind2];
						if (! $ tpdata [pos] [IsLeaf]) {
							if ($ tpdata [pos] [expandida]) {
								. $ ($ T) jqGrid ("collapseRow", $ tpdata [pos]);
								. $ ($ T) jqGrid ("collapseNode", $ tpdata [pos]);
							} Else {
								. $ ($ T) jqGrid ("expandRow", $ tpdata [pos]);
								. $ ($ T) jqGrid ("expandNode", $ tpdata [pos]);
							}
						}
						return false;
					});
				if ($ tpExpandColClick === true) {
					$ ($ T.rows [i]. Células [expCol])
						. Encontrar ("span.cell-wrapper")
						. Css ("cursor", "pointer")
						. Bind ("click", function (e) {
							var target = e.target | | e.srcElement,
							ind2 = $. jgrid.stripPref ($ tpidPrefix, $ (alvo, $ t.rows). mais próximo ("tr.jqgrow") [0]. id),
							pos = $ tp_index [ind2];
							if (! $ tpdata [pos] [IsLeaf]) {
								if ($ tpdata [pos] [expandida]) {
									. $ ($ T) jqGrid ("collapseRow", $ tpdata [pos]);
									. $ ($ T) jqGrid ("collapseNode", $ tpdata [pos]);
								} Else {
									. $ ($ T) jqGrid ("expandRow", $ tpdata [pos]);
									. $ ($ T) jqGrid ("expandNode", $ tpdata [pos]);
								}
							}
							$ ($ T) jqGrid ("setSelection", ind2).;
							return false;
						});
				}
				i + +;
			}

		});
	},
	setTreeGrid: function () {
		voltar this.each (function () {
			var $ t = isso, i = 0, pico, ecol = false, nm, chave, TKey, dupcols = [];
			if ($ tptreeGrid!) {return;}
			if (! $ tptreedatatype) {. $ estender ($ tp, {treedatatype: $ tpdatatype});}
			$ TpsubGrid = false; $ tpaltRows = false;
			$ tppgbuttons = false; $ tppginput = false;
			$ Tpgridview = true;
			if ($ tprowTotal === null) {$ tprowNum = 10000;}
			$ Tpmultiselect = false; $ tprowList = [];
			TpexpColInd $ = 0;
			pico = 'ui-icon-triângulo-1-"+ ($ tpdirection ===" RTL "' w ':' e ');
			. $ TptreeIcons = $ estender ({plus: pico, menos: "ui-icon-triângulo-1-s ', folha:" ui-icon-radio-off'}, $ tptreeIcons | | {});
			if ($ tptreeGridModel === 'aninhado') {
				$ TptreeReader = $. Estender ({
					level_field: "nível",
					left_field: "LFT",
					right_field: "RGT",
					leaf_field: "IsLeaf",
					expanded_field: "expandido",
					carregado: "carregado",
					icon_field: "ícone"
				}, $ TptreeReader);
			} Else if ($ tptreeGridModel === 'adjacência') {
				$ TptreeReader = $. Estender ({
						level_field: "nível",
						parent_id_field: "pai",
						leaf_field: "IsLeaf",
						expanded_field: "expandido",
						carregado: "carregado",
						icon_field: "ícone"
				}, $ TptreeReader);
			}
			for (chave em $ tpcolModel) {
				if ($ tpcolModel.hasOwnProperty (chave)) {
					. nm = $ tpcolModel [chave] nome;
					if (nm === $ tpExpandColumn &&! Ecol) {
						Ecol = true;
						$ TpexpColInd = i;
					}
					i + +;
					/ /
					for (em TKey $ tptreeReader) {
						if ($ tptreeReader.hasOwnProperty (TKey) && $ tptreeReader [TKey] === nm) {
							dupcols.push (nm);
						}
					}
				}
			}
			$. Cada ($ tptreeReader, function (j, n) {
				if (n && $. inArray (n, dupcols) === -1) {
					if (j === 'leaf_field') {$ tp_treeleafpos = i;}
				i + +;
					$ TpcolNames.push (n);
					$tpcolModel.push({name:n,width:1,hidden:true,sortable:false,resizable:false,hidedlg:true,editable:true,search:false});
				}
			});			
		});
	},
	expandRow: function (record) {
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			var childern = $ ($ t). jqGrid ("getNodeChildren", Record),
			/ / If ($ ($ t). JqGrid ("isVisibleNode", ficha)) {
			expandida = $ tptreeReader.expanded_field;
			$ (Children). Cada (function () {
				. var id = $ + $ tpidPrefix jgrid.getAccessor (isto, $ tplocalReader.id);
				. $ (. $ ($ T) jqGrid ('getGridRowById', id)) css ("display", "");
				if (este [expandida]) {
					. $ ($ T) jqGrid ("expandRow", this);
				}
			});
			/ /}
		});
	},
	collapseRow: function (record) {
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			var childern = $ ($ t). jqGrid ("getNodeChildren", Record),
			expandida = $ tptreeReader.expanded_field;
			$ (Children). Cada (function () {
				. var id = $ + $ tpidPrefix jgrid.getAccessor (isto, $ tplocalReader.id);
				. $ (. $ ($ T) jqGrid ('getGridRowById', id)) css ("display", "none");
				if (este [expandida]) {
					$ ($ T) jqGrid ("collapseRow", this).;
				}
			});
		});
	},
	/ / NS, os modelos de adjacência
	getRootNodes: function () {
		var result = [];
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			switch ($ tptreeGridModel) {
				case 'aninhados':
					nível var = $ tptreeReader.level_field;
					$ ($ Tpdata). Cada (function () {
						if (parseInt (este [nível], 10) === parseInt ($ tptree_root_level, 10)) {
							result.push (this);
						}
					});
					break;
				case 'adjacência':
					var parent_id = $ tptreeReader.parent_id_field;
					$ ($ Tpdata). Cada (function () {
						if (este [parent_id] === null | | String (este [parent_id]) toLowerCase () === "nulo".) {
							result.push (this);
						}
					});
					break;
			}
		});
		resultado de retorno;
	},
	getNodeDepth: function (rc) {
		var ret = null;
		this.each (function () {
			if (this.grid | | this.p.treeGrid!) {return;}
			var $ t = this;
			switch ($ tptreeGridModel) {
				case 'aninhados':
					nível var = $ tptreeReader.level_field;
					ret = parseInt (rc [nível], 10) - parseInt ($ tptree_root_level, 10);
					break;
				case 'adjacência':
					ret = $ ($ t) jqGrid ("getNodeAncestors", rc) de comprimento..;
					break;
			}
		});
		voltar ret;
	},
	getNodeParent: function (rc) {
		var resultado = null;
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			switch ($ tptreeGridModel) {
				case 'aninhados':
					var lftc = $ tptreeReader.left_field,
					rgtc = $ tptreeReader.right_field,
					levelc = $ tptreeReader.level_field,
					LFT = parseInt (rc [lftc], 10), RGT = parseInt (rc [rgtc], 10), o nível = parseInt (rc [levelc], 10);
					$ (This.p.data). Cada (function () {
						if (parseInt (este [levelc], 10) === nível 1 && parseInt (este [lftc], 10) <LFT && parseInt (este [rgtc], 10)> RGT) {
							resultado = this;
							return false;
						}
					});
					break;
				case 'adjacência':
					var parent_id = $ tptreeReader.parent_id_field,
					dtid = $ tplocalReader.id;
					$ (This.p.data). Cada (function () {
						if (este [dtid] === $. jgrid.stripPref ($ tpidPrefix, rc [parent_id])) {
							resultado = this;
							return false;
						}
					});
					break;
			}
		});
		resultado de retorno;
	},
	getNodeChildren: function (rc) {
		var result = [];
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			switch ($ tptreeGridModel) {
				case 'aninhados':
					var lftc = $ tptreeReader.left_field,
					rgtc = $ tptreeReader.right_field,
					levelc = $ tptreeReader.level_field,
					LFT = parseInt (rc [lftc], 10), RGT = parseInt (rc [rgtc], 10), o nível = parseInt (rc [levelc], 10);
					$ (This.p.data). Cada (function () {
						if (parseInt (este [levelc], 10) === nível 1 && parseInt (este [lftc], 10)> LFT && parseInt (este [rgtc], 10) <RGT) {
							result.push (this);
						}
					});
					break;
				case 'adjacência':
					var parent_id = $ tptreeReader.parent_id_field,
					dtid = $ tplocalReader.id;
					$ (This.p.data). Cada (function () {
						if (este [parent_id] == $. jgrid.stripPref ($ tpidPrefix, rc [dtid])) {
							result.push (this);
						}
					});
					break;
			}
		});
		resultado de retorno;
	},
	getFullTreeNode: function (rc) {
		var result = [];
		this.each (function () {
			var $ t = isso, len;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			switch ($ tptreeGridModel) {
				case 'aninhados':
					var lftc = $ tptreeReader.left_field,
					rgtc = $ tptreeReader.right_field,
					levelc = $ tptreeReader.level_field,
					LFT = parseInt (rc [lftc], 10), RGT = parseInt (rc [rgtc], 10), o nível = parseInt (rc [levelc], 10);
					$ (This.p.data). Cada (function () {
						if (parseInt (este [levelc], 10)> = nível && parseInt (este [lftc], 10)> = LFT && parseInt (este [lftc], 10) <= RGT) {
							result.push (this);
						}
					});
					break;
				case 'adjacência':
					if (rc) {
					result.push (RC);
					var parent_id = $ tptreeReader.parent_id_field,
					dtid = $ tplocalReader.id;
					$ (This.p.data). Cada (function (i) {
						len = result.length;
						for (i = 0; i <len; i + +) {
							if ($. jgrid.stripPref ($ tpidPrefix, resultado [i] [dtid]) === este [parent_id]) {
								result.push (this);
								break;
							}
						}
					});
					}
					break;
			}
		});
		resultado de retorno;
	},	
	/ / Fim NS, adjacência Modelo
	getNodeAncestors: function (rc) {
		var ancestrais = [];
		this.each (function () {
			if (this.grid | | this.p.treeGrid!) {return;}
			var parent = $ (this) jqGrid ("getNodeParent", rc).;
			while (pai) {
				ancestors.push (pai);
				parent = $ (this) jqGrid ("getNodeParent", pai).;	
			}
		});
		voltar antepassados;
	},
	isVisibleNode: function (rc) {
		var result = true;
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			var antepassados ​​= $ ($ t). jqGrid ("getNodeAncestors", rc),
			expandida = $ tptreeReader.expanded_field;
			$ (Antepassados). Cada (function () {
				result = result && este [expandida];
				if (resultado!) {return false;}
			});
		});
		resultado de retorno;
	},
	isNodeLoaded: function (rc) {
		resultado var;
		this.each (function () {
			var $ t = this;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			var IsLeaf = $ tptreeReader.leaf_field,
			carregado = $ tptreeReader.loaded;
			if (rc! == indefinido) {
				if (rc [carregadas]! == indefinido) {
					Resultado = rc [carregadas];
				} Else if (rc [IsLeaf] | |.. $ ($ T) jqGrid ("getNodeChildren", rc) comprimento> 0) {
					resultado = true;
				} Else {
					resultado = false;
				}
			} Else {
				resultado = false;
			}
		});
		resultado de retorno;
	},
	expandNode: function (rc) {
		voltar this.each (function () {
			if (this.grid | | this.p.treeGrid!) {return;}
			var expandido = this.p.treeReader.expanded_field,
			parent = this.p.treeReader.parent_id_field,
			loaded = this.p.treeReader.loaded,
			level = this.p.treeReader.level_field,
			LFT = this.p.treeReader.left_field,
			RGT = this.p.treeReader.right_field;

			if (rc! [expandida]) {
				. var id = $ jgrid.getAccessor (rc, this.p.localReader.id);
				var rc1 = $ ("#" + + this.p.idPrefix $ jgrid.jqID (id), this.grid.bDiv.) [0];
				posição var = this.p._index [id];
				if ($ this (). jqGrid ("isNodeLoaded", this.p.data [posição])) {
					rc [expandida] = true;
					.. $ ("Div.treeclick", RC1) removeClass (this.p.treeIcons.plus + "árvore-plus") addClass (this.p.treeIcons.minus + "árvore-menos");
				} Else if (this.grid.hDiv.loading!) {
					rc [expandida] = true;
					.. $ ("Div.treeclick", RC1) removeClass (this.p.treeIcons.plus + "árvore-plus") addClass (this.p.treeIcons.minus + "árvore-menos");
					this.p.treeANode = rc1.rowIndex;
					this.p.datatype = this.p.treedatatype;
					if (this.p.treeGridModel === 'aninhado') {
						$(this).jqGrid("setGridParam",{postData:{nodeid:id,n_left:rc[lft],n_right:rc[rgt],n_level:rc[level]}});
					} Else {
						. $ (This) jqGrid ("setGridParam", {postData: {nodeid: id, parentid: rc [pai], n_level: rc [nível]}});
					}
					. $ (This) gatilho ("reloadGrid");
					rc [carregadas] = true;
					if (this.p.treeGridModel === 'aninhado') {
						. $ (This) jqGrid ("setGridParam", {postData: {nodeid:'', n_left:'', n_right:'', n_level:''}});
					} Else {
						. $ (This) jqGrid ("setGridParam", {postData: {nodeid:'', parentid:'', n_level:''}}); 
					}
				}
			}
		});
	},
	collapseNode: function (rc) {
		voltar this.each (function () {
			if (this.grid | | this.p.treeGrid!) {return;}
			var expandido = this.p.treeReader.expanded_field;
			if (rc [expandida]) {
				rc [expandida] = false;
				. var id = $ jgrid.getAccessor (rc, this.p.localReader.id);
				var rc1 = $ ("#" + + this.p.idPrefix $ jgrid.jqID (id), this.grid.bDiv.) [0];
				$ ("Div.treeclick", RC1) removeClass (this.p.treeIcons.minus + "árvore-menos") addClass (this.p.treeIcons.plus + "árvore-plus")..;
			}
		});
	},
	SortTree: function (SortName, newdir, rua, DATEFMT) {
		voltar this.each (function () {
			if (this.grid | | this.p.treeGrid!) {return;}
			var i, len,
			rec, registros = [], $ t = isso, consulta, raízes,
			rt = $ (this) jqGrid ("getRootNodes").;
			/ / raízes Classificando
			consulta = $ jgrid.from (rt).;
			query.orderBy (SortName, newdir, rua, DATEFMT);
			raízes query.select = ();

			/ / Ordenando crianças
			for (i = 0, len = roots.length; i <len; i + +) {
				rec = raízes [i];
				records.push (rec);
				. $ (This) jqGrid ("collectChildrenSortTree", registros, rec, SortName, newdir, rua, DATEFMT);
			}
			$. Cada (registros, function (index) {
				. var id = $ jgrid.getAccessor (isto, $ tplocalReader.id);
				$ (. '#' + $ Jgrid.jqID ($ TPID) + 'tbody tr: eq (' + índice + ')').. After ($ ('tr #' + $ jgrid.jqID (id), $ t . grid.bDiv));
			});
			query = null; raízes = NULL; registros = NULL;
		});
	},
	collectChildrenSortTree: function (registros, rec, SortName, newdir, rua, DATEFMT) {
		voltar this.each (function () {
			if (this.grid | | this.p.treeGrid!) {return;}
			var i, len,
			criança, ch, pergunta, crianças;
			ch = $ (this) jqGrid ("getNodeChildren", rec).;
			query = $ jgrid.from (ch).;
			query.orderBy (SortName, newdir, rua, DATEFMT);
			crianças = query.select ();
			for (i = 0, len = children.length; i <len; i + +) {
				criança crianças = [i];
				records.push (criança);
				. $ (This) jqGrid ("collectChildrenSortTree", registros, criança, SortName, newdir, rua, DATEFMT); 
			}
		});
	},
	/ / Experimental 
	setTreeRow: function (rowid, data) {
		sucesso var = false;
		this.each (function () {
			var t = this;
			se | {return;} (t.grid | tptreeGrid!)
			. sucesso = $ (t) jqGrid ("setRowData", ROWID, dados);
		});
		retornar com êxito;
	},
	delTreeNode: function (rowid) {
		voltar this.each (function () {
			var $ t = isso, livrar = $ tplocalReader.id, i,
			esquerda = $ tptreeReader.left_field,
			direita = $ tptreeReader.right_field, myright, largura, res, chave;
			if ($ t.grid | | $ tptreeGrid!) {return;}
			var rc = $ tp_index [rowid];
			if (rc! == indefinido) {
				/ / Aninhados
				myright = parseInt ($ tpdata [rc] [direita], 10);
				width = myright - parseInt ($ tpdata [RC] [left], 10) + 1;
				. var dr = $ ($ t) jqGrid ("getFullTreeNode", $ tpdata [RC]);
				if (dr.length> 0) {
					for (i = 0; i <dr.length; i + +) {
						. $ ($ T) jqGrid ("delRowData", dr [i] [rid]);
					}
				}
				if ($ tptreeGridModel === "aninhada") {
					/ / TODO - dados grade atualização
					res = $. jgrid.from ($ tpdata)
						. Maior (esquerda, myright, {stype: 'inteiro'})
						. Selecionar ();
					if (res.length) {
						for (chave na res) {
							if (res.hasOwnProperty (chave)) {
								res [chave] [left] = parseInt (res [chave] [left], 10) - largura;
							}
						}
					}
					res = $. jgrid.from ($ tpdata)
						. Maior (direita, myright, {stype: 'inteiro'})
						. Selecionar ();
					if (res.length) {
						for (chave na res) {
							if (res.hasOwnProperty (chave)) {
								res [chave] [right] = parseInt (res [chave] [direita], 10) - largura;
							}
						}
					}
				}
			}
		});
	},
	addChildNode: function (nodeId, parentid, dados expandData) {
		/ / Retorna this.each (function () {
		var $ t = this [0];
		se (dados) {
			/ / Supomos tha o id é autoincremet e
			var expandido = $ tptreeReader.expanded_field,
			IsLeaf = $ tptreeReader.leaf_field,
			level = $ tptreeReader.level_field,
			/ / Icon = $ tptreeReader.icon_field,
			parent = $ tptreeReader.parent_id_field,
			esquerda = $ tptreeReader.left_field,
			direita = $ tptreeReader.right_field,
			carregado = $ tptreeReader.loaded,
			método, parentindex, parentdata, parentlevel, i, len, max = 0, rowind = parentid, folha, maxright;
			if (expandData === indefinido) {expandData = false;}
			if (nodeid === indefinido | | nodeid === null) {
				i = $ tpdata.length-1;
				if (i> = 0) {
					while (i> = 0) {max = Math.max (max, parseInt ($ tpdata [i] [$ tplocalReader.id], 10)); i -;}
				}
				nodeid = max 1;
			}
			var proa = $ ($ t) jqGrid ('getInd', parentid).;
			folha = false;
			/ / Se não um pai assumimos raiz
			if (parentid === indefinido | | parentid === null | | parentid === "") {
				parentid = null;
				rowind = null;
				method = 'último';
				parentlevel = $ tptree_root_level;
				i = $ tpdata.length +1;
			} Else {
				method = "depois";
				parentindex = $ tp_index [parentid];
				parentdata = $ tpdata [parentindex];
				parentid = parentdata [$ tplocalReader.id];
				parentlevel = parseInt (parentdata [nível], 10) +1;
				var criança = $ ($ t) jqGrid ('getFullTreeNode', parentdata).;
				/ / Se há nós filhos se o último índice do mesmo
				if (childs.length) {
					i = criança [childs.length-1] [$ tplocalReader.id];
					rowind = i;
					i = $ ($ t) jqGrid ('getInd', rowind) +1.;
				} Else {
					i = $ ($ t) jqGrid ('getInd', parentid) +1.;
				}
				/ / Se o nó é folha
				if (parentdata [IsLeaf]) {
					folha = true;
					parentdata [expandida] = true;
					. / / Var proa = $ ($ t) jqGrid ('getInd', parentid);
					$ ($ T.rows [proa])
						. Encontrar ("span.cell-wrapperleaf"). RemoveClass ("cell-wrapperleaf"). AddClass ("célula-wrapper")
						. End ()
						. Encontrar ("div.tree-folha") removeClass ($ tptreeIcons.leaf + "árvore de folhas") addClass ($ tptreeIcons.minus + "árvore-menos")..;
					$ Tpdata [parentindex] [IsLeaf] = false;
					parentdata [carregadas] = true;
				}
			}
			len = i +1;

			if (dados [expandida] === indefinidos) {dados [expandida] = false;}
			if (dados [carregadas] === indefinido) {dados [carregadas] = false;}
			dados [nível] = parentlevel;
			if (dados [IsLeaf] === indefinido) {dados [IsLeaf] = true;}
			if ($ tptreeGridModel === "adjacência") {
				dados [parent] = parentid;
			}
			if ($ tptreeGridModel === "aninhada") {
				/ / Este método Requiere mais atenção
				var consulta, res, chave;
				/ / = Maxright parselnt (maxright, 10);
				/ / TODO - dados grade atualização
				if (parentid! == null) {
					maxright = parseInt (parentdata [direita], 10);
					query = $ jgrid.from ($ tpdata).;
					query = query.greaterOrEquals (direita, maxright, {stype: 'inteiro'});
					res = query.select ();
					if (res.length) {
						for (chave na res) {
							if (res.hasOwnProperty (chave)) {
								res [chave] [left] = res [chave] [left]> maxright? parseInt (res [chave] [left], 10) 2: res [chave] [left];
								res [chave] [right] = res [chave] [right]> = maxright? parseInt (res [chave] [direita], 10) 2: res [chave] [direito];
							}
						}
					}
					dados [left] = maxright;
					dados [right] = maxright +1;
				} Else {
					maxright = parseInt ($ ($ t) jqGrid ('getCol', certo, false, 'max'), 10.);
					res = $. jgrid.from ($ tpdata)
						. Maior (esquerda, maxright, {stype: 'inteiro'})
						. Selecionar ();
					if (res.length) {
						for (chave na res) {
							if (res.hasOwnProperty (chave)) {
								res [chave] [left] = parseInt (res [chave] [left], 10) 2;
							}
						}
					}
					res = $. jgrid.from ($ tpdata)
						. Maior (direita, maxright, {stype: 'inteiro'})
						. Selecionar ();
					if (res.length) {
						for (chave na res) {
							if (res.hasOwnProperty (chave)) {
								res [chave] [right] = parseInt (res [chave] [direita], 10) 2;
							}
						}
					}
					dados [left] = maxright +1;
					dados [direita] = maxright + 2;
				}
			}
			if (parentid === null | | $ ($ t) jqGrid ("isNodeLoaded", parentdata) |. | folha) {
					. $ ($ T) jqGrid ('addRowData', nodeid, dados, método rowind);
					$ ($ T) jqGrid ('setTreeNode', i, len).;
			}
			if (parentdata &&! parentdata [expandida] && expandData) {
				$ ($ T.rows [proa])
					. Encontrar ("div.treeclick")
					. Clique ();
			}
		}
		/ /});
	}
});
}) (JQuery);
/ * Jshint eqeqeq: false, eqnull: true * /
/ * JQuery globais * /
/ / Módulo Agrupamento
(Function ($) {
"Use strict";
$. Estender ($. Jgrid, {
	modelo: function (formato) {/ / jqgformat
		.. var args = $ MakeArray (argumentos) fatia (1), j, al = args.length;
		if (formato == null) {format = "";}
		voltar format.replace (/ \ {([\ w \ -] +) (:?.?? \: ([. \ w \] *) (: \ ((*) \))) \} / g, a função (m, i) {
			if (! isNaN (parseInt (i, 10))) {
				retornam args [parseInt (i, 10)];
			}
			for (j = 0; j <ai, j + +) {
				if ($. isArray (args [j])) {
					var nmarr = args [j],
					k = nmarr.length;
					enquanto (k -) {
						if (i === nmarr [k]. nm) {
							retornar nmarr [k] v.;
						}
					}
				}
			}
		});
	}
});
$. Jgrid.extend ({
	groupingSetup: function () {
		voltar this.each (function () {
			var $ t = isso, i, j, cml, cm = $ tpcolModel, grp = $ tpgroupingView;
			if (grp == null && ((typeof grp === 'objeto') | |. $ isFunction (GRP))) {
				if (grp.groupField.length!) {
					$ Tpgrouping = false;
				} Else {
					if (grp.visibiltyOnNextGrouping === indefinido) {
						grp.visibiltyOnNextGrouping = [];
					}

					grp.lastvalues ​​= [];
					grp.groups = [];
					grp.counters = [];
					for (i = 0; i <grp.groupField.length; i + +) {
						if (! grp.groupOrder [i]) {
							grp.groupOrder [i] = 'asc';
						}
						if (! grp.groupText [i]) {
							grp.groupText [i] = '{0}';
						}
						if (typeof grp.groupColumnShow [i]! == 'boolean') {
							grp.groupColumnShow [i] = true;
						}
						if (typeof grp.groupSummary [i]! == 'boolean') {
							grp.groupSummary [i] = false;
						}
						if (grp.groupColumnShow [i] === true) {
							grp.visibiltyOnNextGrouping [i] = true;
							. $ ($ T) jqGrid ('showCol', grp.groupField [i]);
						} Else {
							. grp.visibiltyOnNextGrouping [i] = $ (". #" + $ jgrid.jqID ($ TPID + "_" + grp.groupField [i])) é (": visible");
							. $ ($ T) jqGrid ('hideCol', grp.groupField [i]);
						}
					}
					grp.summary = [];
					for (j = 0, = cm.length cml; j <cml; j + +) {
						if (cm [j]. SummaryType) {
							if (cm [j]. summaryDivider) {
								grp.summary.push ({nm: cm [j] nome, rua:. cm [j] SummaryType, v:.'', sd: cm [j] summaryDivider, vd:.'', sr: cm [j] .. summaryRound, srt: cm [j] summaryRoundType | | 'round'});
							} Else {
								grp.summary.push ({nm: cm [j] nome, rua: cm [j] SummaryType, v:'', sr: cm [j] summaryRound, srt: cm [j] summaryRoundType | | '.... round '});
							}
						}
					}
				}
			} Else {
				$ Tpgrouping = false;
			}
		});
	},
	groupingPrepare: function (rdata, gdata, ficha, irow) {
		this.each (function () {
			var grp = this.p.groupingView, $ t = isso, i,
			grlen = grp.groupField.length, 
			fieldName,
			v,
			displayName,
			displayValue,
			mudou = 0;
			for (i = 0; i <grlen; i + +) {
				nomeCampo = grp.groupField [i];
				displayName = grp.displayField [i];
				v = record [nomeCampo];
				displayValue = displayName == null? null: registro [displayName];

				if (displayValue == null) {
					displayValue = v;
				}
				if (v! == indefinido) {
					if (irow === 0) {
						/ / Primeiro registro sempre começa um novo grupo
						grp.groups.push ({idx: i, dataIndex: nomeCampo, valor: v, displayValue: displayValue, startRow: irow, cnt: 1, resumo: []});
						grp.lastvalues ​​[i] = v;
						grp.counters [i] = {cnt: 1, pos: grp.groups.length-1, resumo:. $ estender (true, [], grp.summary)};
						$. Cada (grp.counters [i]. Sumárias, function () {
							if ($. isFunction (this.st)) {
								this.v = this.st.call ($ t, this.v, this.nm, ficha);
							} Else {
								. this.v = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.v, this.nm, this.sr, This.srt, ficha);
								if (this.st.toLowerCase () === 'média' && this.sd) {
									. this.vd = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.vd, this.sd, this.sr, This.srt, ficha);
								}
							}
						});
						.. grp.groups [. grp.counters [i] pos] summary = grp.counters [i] sumário;
					} Else {
						if (typeof v! == "objeto" && ($. isArray (grp.isInTheSameGroup) && $. isFunction (grp.isInTheSameGroup [i])! grp.isInTheSameGroup [i] chamada. ($ t, grp.lastvalues ​​[ i], v, i, GRP):! grp.lastvalues ​​[i] == v)) {
							/ / Este registro não está na mesma faixa que o anterior
							grp.groups.push ({idx: i, dataIndex: nomeCampo, valor: v, displayValue: displayValue, startRow: irow, cnt: 1, resumo: []});
							grp.lastvalues ​​[i] = v;
							mudou = 1;
							grp.counters [i] = {cnt: 1, pos: grp.groups.length-1, resumo:. $ estender (true, [], grp.summary)};
							$. Cada (grp.counters [i]. Sumárias, function () {
								if ($. isFunction (this.st)) {
									this.v = this.st.call ($ t, this.v, this.nm, ficha);
								} Else {
									. this.v = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.v, this.nm, this.sr, This.srt, ficha);
									if (this.st.toLowerCase () === 'média' && this.sd) {
										. this.vd = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.vd, this.sd, this.sr, This.srt, ficha);
									}
								}
							});
							.. grp.groups [. grp.counters [i] pos] summary = grp.counters [i] sumário;
						} Else {
							if (mudado === 1) {
								/ / Este grupo mudou porque um grupo anteriormente alterado.
								grp.groups.push ({idx: i, dataIndex: nomeCampo, valor: v, displayValue: displayValue, startRow: irow, cnt: 1, resumo: []});
								grp.lastvalues ​​[i] = v;
								grp.counters [i] = {cnt: 1, pos: grp.groups.length-1, resumo:. $ estender (true, [], grp.summary)};
								$. Cada (grp.counters [i]. Sumárias, function () {
									if ($. isFunction (this.st)) {
										this.v = this.st.call ($ t, this.v, this.nm, ficha);
									} Else {
										. this.v = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.v, this.nm, this.sr, This.srt, ficha);
										if (this.st.toLowerCase () === 'média' && this.sd) {
											. this.vd = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.vd, this.sd, this.sr, This.srt, ficha);
										}
									}
								});
								.. grp.groups [. grp.counters [i] pos] summary = grp.counters [i] sumário;
							} Else {
								grp.counters [i] cnt + = 1.;
								. grp.groups [. grp.counters [i] pos] cnt = grp.counters [i] cnt.;
								$. Cada (grp.counters [i]. Sumárias, function () {
									if ($. isFunction (this.st)) {
										this.v = this.st.call ($ t, this.v, this.nm, ficha);
									} Else {
										. this.v = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.v, this.nm, this.sr, This.srt, ficha);
										if (this.st.toLowerCase () === 'média' && this.sd) {
											. this.vd = $ ($ t) jqGrid ('groupingCalculations.handler', this.st, this.vd, this.sd, this.sr, This.srt, ficha);
										}
									}
								});
								.. grp.groups [. grp.counters [i] pos] summary = grp.counters [i] sumário;
							}
						}
					}
				}
			}
			gdata.push (rdata);
		});
		voltar gdata;
	},
	groupingToggle: function (HID) {
		this.each (function () {
			var $ t = isso,
			grp = $ tpgroupingView,
			strpos = hid.split ('_'),
			num = parseInt (strpos [strpos.length-2], 10);
			strpos.splice (strpos.length-2, 2);
			var uid = strpos.join ("_"),
			menos = grp.minusicon,
			mais = grp.plusicon,
			tar = $ ("#" + $. jgrid.jqID (HID)),
			r = tar.length? . tar [0] nextSibling: null,
			tarspan = $ ("#" + $. jgrid.jqID (HID) + "span." + "árvore-wrap-" + $ tpdirection),
			getGroupingLevelFromClass = function (className) {
				var nums = $. mapa (className.split (""), function (item) {
					if (item.substring (0, uid.length + 1) === uid + "_") {
						retornar parselnt (item.substring (uid.length + 1), 10);
					}
				});
				retornar nums.length> 0? nums [0]: undefined;
			},
			itemGroupingLevel,
			showdata,
			desmoronou = false;
			if (tarspan.hasClass (menos)) {
				if (grp.showSummaryOnHide) {
					if (r) {
						enquanto (r) {
							if ($ (r). hasClass ('jqfoot')) {
								var lv = parseInt ($ (r) attr ("jqfootlevel"), 10.);
								if (lv <= num) {
									break;
								}
							}
							. $ (R) esconder ();
							r = r.nextSibling;
						}
					}
				} Else {
					if (r) {
						enquanto (r) {
							itemGroupingLevel = getGroupingLevelFromClass (r.className);
							if (itemGroupingLevel! == indefinido && itemGroupingLevel <= num) {
								break;
							}
							. $ (R) esconder ();
							r = r.nextSibling;
						}
					}
				}
				tarspan.removeClass (menos) addClass (plus).;
				desmoronou = true;
			} Else {
				if (r) {
					showdata = indefinido;
					enquanto (r) {
						itemGroupingLevel = getGroupingLevelFromClass (r.className);
						if (showdata === indefinido) {
							showdata = itemGroupingLevel === indefinido / / se a primeira linha depois que o grupo de abertura é linha de dados, em seguida, mostrar as linhas de dados
						}
						if (itemGroupingLevel! == indefinido) {
							if (itemGroupingLevel <= num) {
								quebrar ;/ / item seguinte da mesma alavanca são encontrados
							}
							if (itemGroupingLevel === num + 1) {
								.... $ (R) show () encontrar (".> Td> extensão" + "árvore-wrap-" + $ tpdirection) removeClass (menos) addClass (plus);
							}
						} Else if (showdata) {
							. $ (R) show ();
						}
						r = r.nextSibling;
					}
				}
				. tarspan.removeClass (mais) addClass (menos);
			}
			. $ ($ T) triggerHandler ("jqGridGroupingClickGroup", [escondeu, desabou]);
			if ($ isFunction ($ tponClickGroup).) {$ tponClickGroup.call ($ t, escondido, entrou em colapso);}

		});
		return false;
	},
	groupingRender: function (grdata, colspans) {
		voltar this.each (function () {
			var $ t = isso,
			grp = $ tpgroupingView,
			str = "", icon = "", escondido, clid, pmrtl = grp.groupCollapse? grp.plusicon: grp.minusicon, gv, cp = [], len = grp.groupField.length;
			pmrtl + = "tree-wrap-" + $ tpdirection; 
			$. Cada ($ tpcolModel, function (i, n) {
				var ii;
				para (ii = 0; ii <len; ii + +) {
					if (grp.groupField [ii] === n.name) {
						cp [ii] = i;
						break;
					}
				}
			});
			var toEnd = 0;
			funcionar findGroupIdx (ind, offset, grp) {
				var ret = false, i;
				if (compensado === 0) {
					ret = grp [ind];
				} Else {
					id = var grp [ind] idx.;
					if (ID === 0) { 
						ret = grp [ind]; 
					} Else {
						for (i = ind; i> = 0; i -) {
							if (grp [i]. idx === compensar-id) {
								ret = grp [i];
								break;
							}
						}
					}
				}
				voltar ret;
			}
			. var sumreverse = $ MakeArray (grp.groupSummary);
			sumreverse.reverse ();
			$. Cada (grp.groups, function (i, n) {
				toEnd + +;
				clid = $ TPID + "ghead_" + n.idx;
				escondeu = clid + "_" + i;
				icon = ". <span style =" cursor: pointer; "class =" ui-icon "+ pmrtl +" 'onclick = \ "jQuery (" # ". + $ jgrid.jqID ($ TPID) +" ") jqGrid ( 'groupingToggle', '"+ escondido +"'); return false; \ "> </ span>";
				try {
					if ($. isArray (grp.formatDisplayField) && $. isFunction (grp.formatDisplayField [n.idx])) {
						. n.displayValue = grp.formatDisplayField [n.idx] call ($ t, n.displayValue, n.value, $ tpcolModel [cp [n.idx]], n.idx, grp);
						gv = n.displayValue;
					} Else {
						gv = $ t.formatter (HID, n.displayValue, cp [n.idx], n.value);
					}
				} Catch (EGV) {
					gv = n.displayValue;
				}
				"? <tr id=\""+hid+"\"" +(grp.groupCollapse && n.idx> 0" str + = style = \ "display: none; \" ":" ") +" role = \ "linha \" class = \ "ui-widget-content jqgroup ui-linha-" + $ tpdirection + "" + clid + "\"> <estilo td = \ "padding-left:" + (n.idx * 12) + "px";. + "\" colspan = \ "" + colspans + "\"> "+ ícone + $ jgrid.template (grp.groupText [n.idx], gv, n.cnt, n.summary) +" < / td> </ tr> ";
				folha var = len-1 === n.idx; 
				if (folha) {
					var gg = grp.groups [i +1], k, kk, ik;
					final var = gg! == indefinido? . grp.groups [i +1] startRow: grdata.length;
					for (kk = n.startRow; kk <end; kk + +) {
						. str + = grdata [kk] join ('');
					}
					var jj;
					if (gg! == indefinido) {
						para (jj = 0; jj <grp.groupField.length; jj + +) {
							if (gg.dataIndex === grp.groupField [jj]) {
								break;
							}
						}
						toEnd = grp.groupField.length - jj;
					}
					para (ik = 0; ik <toEnd; ik + +) {
						if (! sumreverse [ik]) {continue;}
						var hhdr = "";
						if (grp.showSummaryOnHide grp.groupCollapse &&!) {
							hhdr = "style = \" display: none; \ "";
						}
						str + = "<tr" + hhdr + "jqfootlevel = \" "+ (n.idx-ik) +" \ "role = \ class" linha \ "= \" jqfoot ui-ui-row-widget-content "+ $ tpdirection + "\"> ";
						var fdata = findGroupIdx (i, ik, grp.groups),
						cm = $ tpcolModel,
						vv, grlen = fdata.cnt;
						for (k = 0; k <colspans; k + +) {
							var tmpdata = "<td "+$t.formatCol(k,1,'')+"> </ td>",
							tplfld = "{0}";
							$. Cada (fdata.summary, function () {
								if (this.nm === cm [k]. name) {
									if (cm [k]. summaryTpl) {
										tplfld = cm [k] summaryTpl.;
									}
									if (typeof this.st === 'string' && this.st.toLowerCase () === 'média') {
										if (this.sd && this.vd) { 
											this.v = (this.v / this.vd);
										} Else if (this.v && grlen> 0) {
											this.v = (this.v / grlen);
										}
									}
									try {
										vv = $ t.formatter ('', this.v, k, this);
									} Catch (ef) {
										vv = this.v;
									}
									. tmpdata = "<td "+$t.formatCol(k,1,'')+">" + $ jgrid.format (tplfld, vv) + "</ td>";
									return false;
								}
							});
							str + = tmpdata;
						}
						str + = "</ tr>";
					}
					toEnd = jj;
				}
			});
			. $ (. "#" + $ Jgrid.jqID ($ TPID) + "tbody: primeiro") anexar (str);
			Memória / / liberar
			str = null;
		});
	},
	groupingGroupBy: function (nome, options) {
		voltar this.each (function () {
			var $ t = this;
			if (nome typeof === "string") {
				name = [nome];
			}
			var grp = $ tpgroupingView;
			$ Tpgrouping = true;

			/ / Set padrão, no caso visibilityOnNextGrouping é indefinido 
			if (grp.visibiltyOnNextGrouping === indefinido) {
				grp.visibiltyOnNextGrouping = [];
			}
			var i;
			/ / Mostrar grupos ocultos anteriores, se eles estão escondidos e ainda não foram retirados
			for (i = 0; i <grp.groupField.length; i + +) {
				if (! grp.groupColumnShow [i] && grp.visibiltyOnNextGrouping [i]) {
				. $ ($ T) jqGrid ('showCol', grp.groupField [i]);
				}
			}
			Status de visibilidade / / conjunto de colunas grupo atual na próxima agrupamento
			for (i = 0; i <name.length; i + +) {
				grp.visibiltyOnNextGrouping [i] = $ ("#" + $ jgrid.jqID ($ TPID) + "_" + $ jgrid.jqID (nome [i])..) é (": visible").;
			}
			. $ TpgroupingView = $ estender ($ tpgroupingView, opções | | {});
			grp.groupField = nome;
			. $ ($ T) gatilho ("reloadGrid");
		});
	},
	groupingRemove: function (atual) {
		voltar this.each (function () {
			var $ t = this;
			if (=== corrente indefinido) {
				atual = true;
			}
			$ Tpgrouping = false;
			if (atual === true) {
				var grp = $ tpgroupingView, i;
				/ / Mostrar grupos ocultos anteriores, se eles estão escondidos e ainda não foram retirados
				for (i = 0; i <grp.groupField.length; i + +) {
				if (! grp.groupColumnShow [i] && grp.visibiltyOnNextGrouping [i]) {
						$ ($ T) jqGrid ('showCol', grp.groupField).;
					}
				}
				. $ (". Tr.jqgroup, tr.jqfoot", "#" + $ jgrid.jqID ($ TPID) + "tbody: primeiro") remove ();
				. $ (". Tr.jqgrow: escondido", "#" + $ jgrid.jqID ($ TPID) + "tbody: primeiro") show ();
			} Else {
				. $ ($ T) gatilho ("reloadGrid");
			}
		});
	},
	groupingCalculations: {
		handler: function (fn, v, campo, redondo, roundType, rc) {
			funcs var = {
				soma: function () {
					voltar parseFloat (v | | 0) + parseFloat ((rc [campo] | | 0));
				},

				min: function () {
					if (v === "") {
						voltar parseFloat (rc [campo] | | 0);
					}
					voltar Math.min (parseFloat (v), parseFloat (rc [campo] | | 0));
				},

				máx: function () {
					if (v === "") {
						voltar parseFloat (rc [campo] | | 0);
					}
					voltar Math.max (parseFloat (v), parseFloat (rc [campo] | | 0));
				},

				contagem: function () {
					if (v === "") {x = 0;}
					if (rc.hasOwnProperty (campo)) {
						voltar v 1;
					}
					return 0;
				},

				avg: function () {
					/ / O mesmo que soma, mas ao final, dividi-lo
					/ / Então use soma em vez de duplicar o código (?)
					funcs.sum voltar ();
				}
			};

			if (! funcs [fn]) {
				jogar ("jqGrid Agrupamento Sem esse método:" + fn);
			}
			res var = funcs [fn] ();

			if (round! = null) {
				if (roundType === 'fixo') {
					res = res.toFixed (redondo);
				} Else {
					var mul = Math.pow (10, e volta);
					res = Math.round (res * mul) / mul;
				}
			}

			voltar res;
		}	
	}
});
}) (JQuery);
/ * Jshint eqeqeq: false, eqnull: true, desenvolvi: true * /
/ * JQuery global, xmlJsonClass * /
(Function ($) {
/ *
 * Extensão jqGrid para a construção de grade de dados de arquivo externo
 * Tony Tomov tony@trirand.com
 * Http://trirand.com/blog/ 
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
** / 

"Use strict";
    $. Jgrid.extend ({
        jqGridImport: function (o) {
            o = $. estender ({
                imptype: "xml", / / ​​XML, JSON, xmlString, jsonstring
                impstring: "",
                impurl: "",
                mtype: "GET",
                impData: {},
                {: xmlGrid
                    config: "raízes> grid",
                    dados: "Raízes> linhas"
                },
                jsonGrid: {
                    config: "grid",
                    dados: "dados"
                },
                AjaxOptions: {}
            }, O | | {});
            voltar this.each (function () {
                var $ t = this;
                var XmlConvert = function (xml, o) {
                    var cnfg = $ (o.xmlGrid.config, xml) [0];
                    var xmldata = $ (o.xmlGrid.data, xml) [0], jstr, jstr1, chave;
                    if ($ xmlJsonClass.xml2json &&. jgrid.parse) {
                        jstr = xmlJsonClass.xml2json (cnfg, "");
                        jstr = $ jgrid.parse (jstr).;
                        for (chave na jstr) {
                            if (jstr.hasOwnProperty (chave)) {
                                jstr1 = jstr [key];
                            }
                        }
                        if (xmldata) {
                        / / Salva o tipo de dados
                            var svdatatype = jstr.grid.datatype;
                            jstr.grid.datatype = 'xmlString';
                            jstr.grid.datastr = xml;
                            . $ ($ T) jqGrid (jstr1) jqGrid ("setGridParam", {tipo de dados: svdatatype}).;
                        } Else {
                            . $ ($ T) jqGrid (jstr1);
                        }
                        jstr = null; jstr1 = null;
                    } Else {
                        alert ("xml2json ou de análise não estão presentes");
                    }
                };
                var jsonConvert = function (jsonstr, o) {
                    if (typeof jsonstr && jsonstr === 'string') {
						var _jsonparse = false;
						if ($. jgrid.useJSON) {
							. $ Jgrid.useJSON = false;
							_jsonparse = true;
						}
                        . var json = $ jgrid.parse (jsonstr);
						if (_jsonparse) {$ jgrid.useJSON = true;.}
                        var GPRM = json [o.jsonGrid.config];
                        var jdata = json [o.jsonGrid.data];
                        if (jdata) {
                            var svdatatype = gprm.datatype;
                            gprm.datatype = 'jsonstring';
                            gprm.datastr = jdata;
                            . $ ($ T) jqGrid (GPRM) jqGrid ("setGridParam", {tipo de dados: svdatatype}).;
                        } Else {
                            $ ($ T) jqGrid (GPRM).;
                        }
                    }
                };
                switch (o.imptype) {
                    caso 'xml':
                        $. Ajax ($. Estender ({
                            url: o.impurl,
                            digite: o.mtype,
                            Dados: o.impData,
                            Tipo de dado: "xml",
                            completar: function (xml, status) {
                                if (status === 'sucesso') {
                                    XmlConvert (xml.responseXML, o);
                                    . $ ($ T) triggerHandler ("jqGridImportComplete" [xml, o]);
                                    if ($. isFunction (o.importComplete)) {
                                        o.importComplete (xml);
                                    }
                                }
                                xml = null;
                            }
                        }, O.ajaxOptions));
                        break;
                    case 'xmlString':
                        / / Precisamos fazer apenas a conversão e usar o mesmo código xml
                        if (typeof o.impstring && o.impstring === 'string') {
                            . var xmld = $ parseXML (o.impstring);
                            if (xmld) {
                                XmlConvert (xmld, o);
                                . $ ($ T) triggerHandler ("jqGridImportComplete" [xmld, o]);
                                if ($. isFunction (o.importComplete)) {
                                    o.importComplete (xmld);
                                }
                                o.impstring = null;
                            }
                            xmld = null;
                        }
                        break;
                    case 'json':
                        $. Ajax ($. Estender ({
                            url: o.impurl,
                            digite: o.mtype,
                            Dados: o.impData,
                            Tipo de dado: "json",
                            completa: function (json) {
                                try {
                                    jsonConvert (json.responseText, o);
                                    . $ ($ T) triggerHandler ("jqGridImportComplete" [json, o]);
                                    if ($. isFunction (o.importComplete)) {
                                        o.importComplete (JSON);
                                    }
                                } Catch (ee) {}
                                json = null;
                            }
                        }, O.ajaxOptions));
                        break;
                    case 'jsonstring':
                        if (typeof o.impstring && o.impstring === 'string') {
                            jsonConvert (o.impstring, o);
                            . $ ($ T) triggerHandler ("jqGridImportComplete" [o.impstring, o]);
                            if ($. isFunction (o.importComplete)) {
                                o.importComplete (o.impstring);
                            }
                            o.impstring = null;
                        }
                        break;
                }
            });
        },
        jqGridExport: function (o) {
            o = $. estender ({
                exptype: "xmlString",
                root: "grid",
                ident: "\ t"
            }, O | | {});
            var ret = null;
            this.each (function () {
                Se {return;} (this.grid!)
                chave var, GPRM = $ estender (true, {}, $ (this) jqGrid ("getGridParam").).;
                / / É necessário verificar:
                / / 1.multiselect, 2.subgrid 3. TreeGrid e remover as colunas unneded de COLNAMES
                if () {gprm.rownumbers
                    gprm.colNames.splice (0,1);
                    gprm.colModel.splice (0,1);
                }
                if (gprm.multiselect) {
                    gprm.colNames.splice (0,1);
                    gprm.colModel.splice (0,1);
                }
                if (gprm.subGrid) {
                    gprm.colNames.splice (0,1);
                    gprm.colModel.splice (0,1);
                }
                gprm.knv = null;
                if (gprm.treeGrid) {
                    for (chave na gprm.treeReader) {
                        if (gprm.treeReader.hasOwnProperty (chave)) {
                            gprm.colNames.splice (gprm.colNames.length-1);
                            gprm.colModel.splice (gprm.colModel.length-1);
                        }
                    }
                }
                switch (o.exptype) {
                    case 'xmlString':
                        ret = "<" + o.root + ">" + xmlJsonClass.json2xml (GPRM, o.ident) + "</" + o.root + ">";
                        break;
                    case 'jsonstring':
                        ret = "{" + xmlJsonClass.toJson (GPRM, o.root, o.ident, false) + "}";
                        if (! == gprm.postData.filters indefinido) {
                            ret = (ret.replace / filtros ":" /, "filters": ');
                            ret = ret.replace (/}]} "/, '}]}');
                        }
                        break;
                }
            });
            voltar ret;
        },
        ExcelExport: function (o) {
            o = $. estender ({
                exptype: "remota",
                url: null,
                Oper: "operar",
                tag: "Excel",
                ExportOptions: {}
            }, O | | {});
            voltar this.each (function () {
                Se {return;} (this.grid!)
                var url;
                if (o.exptype === "remoto") {
                    . var pdata = $ estender ({}, this.p.postData);
                    pdata [o.oper] = o.tag;
                    var params = jQuery.param (pdata);
                    if (o.url.indexOf () == -1 "?"!) {url = o.url + "&" + params;}
                    else {"?" url = o.url + + params;}
                    window.location = url;
                }
            });
        }
    });
}) (JQuery);
/ * Jshint mal: true, eqeqeq: false, eqnull: true, desenvolvi: true * /
/ * JQuery globais * /
(Function ($) {
/ *
**
 * addons jqgrid usando jQuery UI 
 * Autor: Mark Williams
 * Dupla licenciado sob as licenças MIT e GPL:
 * Http://www.opensource.org/licenses/mit-license.php
 * Http://www.gnu.org/licenses/gpl-2.0.html
 * Depende jQuery UI 
** /
"Use strict";
if ($. jgrid.msie && $. jgrid.msiever () === 8) {
	. $ Expr [":"]. Escondido = function (elem) {
		voltar elem.offsetWidth === 0 | | elem.offsetHeight === 0 | |
			elem.style.display === "none";
	};
}
/ / Requiere carga de várias seleções antes de grade
. $ Jgrid._multiselect = false;
if ($. ui) {
	if ($. ui.multiselect) {
		if ($. ui.multiselect.prototype._setSelected) {
			. var setSelected = $ ui.multiselect.prototype._setSelected;
			$. Ui.multiselect.prototype._setSelected = function (item, selecionado) {
				var ret = setSelected.call (este, um item selecionado);
				if (seleccionado && this.selectedList) {
					var elt = this.element;
					this.selectedList.find ('li'). cada (function () {
						if ($ (this). dados ('optionLink')) {
							... $ (This) dados ('optionLink') remove () appendTo (elt);
						}
					});
				}
				voltar ret;
			};
		}
		if ($. ui.multiselect.prototype.destroy) {
			$. Ui.multiselect.prototype.destroy = function () {
				this.element.show ();
				this.container.remove ();
				if ($. Widget === indefinido) {
					$ Widget.prototype.destroy.apply (isso, argumentos).;
				} Else {
					. $ Widget.prototype.destroy.apply (isso, argumentos);
				}
			};
		}
		$ Jgrid._multiselect = true.;
	}
}
        
$. Jgrid.extend ({
	sortableColumns: function (tblrow)
	{
		voltar this.each (function () {
			ts = var isso, tid = $ jgrid.jqID (ts.p.id).;
			função start () {ts.p.disableClick = true;}
			sortable_opts var = {
				"Tolerância": "ponteiro",
				"Eixo": "x",
				"ScrollSensitivity": "1",
				"itens": '> th: não (: tem (# jqgh_' + tid + '_cb' + ', # jqgh_' + tid + '_rn' + ', # jqgh_' + tid + '_subgrid): oculto) ",
				"Espaço reservado": {
					elemento: function (item) {
						var el = $ (document.createElement (ponto [0]. nodeName))
						. AddClass (ponto [0]. ClassName + "ui-ui classificável-espaço reservado pelo Estado-destaque")
						. RemoveClass ("ui-classificável-helper") [0];
						voltar el;
					},
					update: function (self, p) {
						p.height (self.currentItem.innerHeight () - parseInt (self.currentItem.css ('paddingTop') | | 0, 10) - parseInt (self.currentItem.css ('paddingBottom') | | 0, 10)) ;
						p.width (self.currentItem.innerWidth () - parseInt (self.currentItem.css ('paddingLeft') | | 0, 10) - parseInt (self.currentItem.css ('paddingRight') | | 0, 10)) ;
					}
				},
				"Atualizar": function (event, ui) {
					var p = $ (ui.item). parent (),
					ª = $ ("> th", p),
					colModel = ts.p.colModel,
					cmMap = {}, tid = ts.p.id + "_";
					. $ Cada (colModel, function (i) {cmMap [this.name] = i;});
					var permutação = [];
					th.each (function () {
						. var id = $ ("> div", this) se (0) id.replace (/ ^ jqgh_ /, "") substituir (tid,. "").;
							if (cmMap.hasOwnProperty (id)) {
								permutation.push (cmMap [id]);
							}
					});
	
					. $ (Ts) jqGrid ("remapColumns", permutação, verdade, verdade);
					if ($. isFunction (ts.p.sortable.update)) {
						ts.p.sortable.update (permuta);
					}
					setTimeout (function () {ts.p.disableClick = false;}, 50);
				}
			};
			if () {ts.p.sortable.options
				. $ Estender (sortable_opts, ts.p.sortable.options);
			} Else if ($. IsFunction (ts.p.sortable)) {
				ts.p.sortable = {"update": ts.p.sortable};
			}
			if (sortable_opts.start) {
				var s = sortable_opts.start;
				sortable_opts.start = function (e, ui) {
					start ();
					s.call (esta, e, ui);
				};
			} Else {
				sortable_opts.start = partida;
			}
			if (ts.p.sortable.exclude) {
				sortable_opts.items + = ": não (" + ts.p.sortable.exclude + ")";
			}
			tblrow.sortable (sortable_opts) de dados ("classificáveis") flutuante = true..;
		});
	},
    columnChooser: function (opta) {
        var auto = this;
		Se {return;} ($ ("# colchooser_" + $ jgrid.jqID (auto [0] p.id)) de comprimento...)
        seletor var = $ ('<div id="colchooser_'+self[0].p.id+'" style="position:relative;overflow:hidden"> <div> <selecione multiple="multiple"> </ select > </ div> </ div> ');
        var escolha = $ ('selecionar', seletor);
		
		inserção de função (perm, i, v) {
			if (i> = 0) {
				var a = perm.slice ();
				var b = a.splice (i, Math.max (perm.length-i, i));
				if (i> perm.length) {i = perm.length;}
				a [i] = v;
				retorno a.concat (b);
			}
		}
        opta = $. estender ({
            "Width": 420,
            "Height": 240,
            "Classname": null,
            "Done": function (perm) {if (perm) {self.jqGrid ("remapColumns", perm, true);}},
            / * MSEL é o nome de uma classe Widget que ui
               estende-se uma seleção múltipla, ou uma função que suporta
               a criação de um objeto de várias seleções (com nenhum argumento,
               ou quando passado um objeto), e destruí-lo (quando
               passou a string "destruir"). * /
            "MSEL": "seleção múltipla",
            / * "Msel_opts": {}, * /

            / * Dlog é o nome de uma classe Widget que ui 
               comporta-se de uma maneira semelhante de diálogo, ou uma função, que
               apoia a criação de um diálogo (quando passou dlog_opts)
               ou a destruição de uma caixa de diálogo (quando passou a string
               "Destruir")
               * /
            "Dlog": "diálogo",
			"dialog_opts": {
				"MinWidth": 470
			},
            / * Dlog_opts é tanto um objecto opção a ser passado 
               para "dlog", ou (mais provavelmente) uma função que gera
               as opções objeto.
               O padrão produz um objeto adequado para opções
               ui.dialog * /
            "dlog_opts": function () {opts
                botões var = {};
                botões [opts.bSubmit] = function () {
                    opts.apply_perm ();
                    opts.cleanup (false);
                };
                botões [opts.bCancel] = function () {
                    opts.cleanup (true);
                };
                return $. estender (true, {
                    "botões": botões,
                    "Fechar": function () {
                        opts.cleanup (true);
                    },
					"Modal": opts.modal | | falso
					"Redimensionável": opts.resizable | | verdade,
                    "Width": opts.width +20
                }, Opts.dialog_opts | | {});
            },
            / * Função para obter a matriz de permutação, e passá-lo para o
               Função "feito" * /
            "Apply_perm": function () {
                $ ('Opção', selecione). Cada (function () {
                    if (this.selected) {
                        self.jqGrid ("showCol", colModel [this.value] nome.);
                    } Else {
                        self.jqGrid ("hideCol", colModel [this.value] nome.);
                    }
                });
                
                var perm = [];
				/ / FixedCols.slice (0);
                $. ('Option: selected', selecionar) each (function () {perm.push (parseInt (this.value, 10));});
                . $ Cada (perm, function () {apagar colMap [colModel [parseInt (isso, 10)] nome.];});
                $. Cada (colMap, function () {
					var ti = parselnt (isto, 10);
					perm = inserir (perm, ti, ti);
				});
                if (opts.done) {
                    opts.done.call (self, perm);
                }
            },
            / * Função para limpeza de diálogo, e selecione. Também chama a
               função feito sem permutação (para indicar que o
               columnChooser foi abortada * /
            "Limpeza": function (calldone) {
                call (opts.dlog, seletor, 'destruir');
                ligar para (opts.msel, selecionar 'destruir');
                selector.remove ();
                if (calldone && opts.done) {
                    opts.done.call (self);
                }
            },
			"msel_opts": {}
        .}, $ Jgrid.col, opta | | {});
		if ($. ui) {
			if ($. ui.multiselect) {
				if (opts.msel === "seleção múltipla") {
					if (! $. jgrid._multiselect) {
						/ / Deve estar no arquivo de idioma
						alert ("plug-in Multiselect carregado após jqGrid favor carregar o plugin antes do jqGrid.!");
						retorno;
					}
					. (. $ ui.multiselect.defaults, opts.msel_opts) opts.msel_opts = $ estender;
				}
			}
		}
        if (opts.caption) {
            selector.attr ("title", opts.caption);
        }
        if (opts.classname) {
            selector.addClass (opts.classname);
            select.addClass (opts.classname);
        }
        if (opts.width) {
            . $ ("> Div", seletor) css ({"width": opts.width, "margem": "0 auto"});
            select.css ("width", opts.width);
        }
        if (opts.height) {
            . $ ("> Div", seletor) css ("altura", opts.height);
            select.css ("altura", opts.height - 10);
        }
        var colModel = self.jqGrid ("getGridParam", "colModel");
        var COLNAMES = self.jqGrid ("getGridParam", "COLNAMES");
        var colMap = {}, fixedCols = [];

        select.empty ();
        $. Cada (colModel, function (i) {
            colMap [this.name] = i;
            if (this.hidedlg) {
                if (this.hidden!) {
                    fixedCols.push (i);
                }
                retorno;
            }

            select.append ("<valor da opção = '" + i + "'" +
                          (? This.hidden "": "selected = 'selecionados'") + ">". + $ Jgrid.stripHtml (COLNAMES [i]) + "</ option>");
        });
        chamada de função (fn, obj) {
            if (fn!) {return;}
            if (typeof fn === 'string') {
                if ($. fn [fn]) {
                    .. $ Fn [fn] aplicam-se (.. Obj, $ MakeArray (argumentos) fatia (2));
                }
            } Else if ($. IsFunction (fn)) {
                fn.apply (.. obj, $ MakeArray (argumentos) fatia (2));
            }
        }

        var dopts = $. isFunction (opts.dlog_opts)? opts.dlog_opts.call (self, opta): opts.dlog_opts;
        call (opts.dlog, seletor, dopts);
        var mopts = $. isFunction (opts.msel_opts)? opts.msel_opts.call (self, opta): opts.msel_opts;
        Ligue para (opts.msel selecione, mopts);
    },
	sortableRows: function () {opts
		/ / Pode aceitar todas as opções e eventos classificáveis
		voltar this.each (function () {
			var $ t = this;
			if ($ t.grid!) {return;}
			/ / Atualmente desativar um classificáveis ​​TreeGrid
			if ($ tptreeGrid) {return;}
			if ($. fn.sortable) {
				opta = $. estender ({
					"Cursor": "mover-se",
					"Eixo": "y",
					"itens": "jqgrow".
					},
				opta | | {});
				if ($ opts.start &&. isFunction (opts.start)) {
					opts._start_ = opts.start;
					excluir opts.start;
				} Else {opts._start_ = false;}
				if ($ opts.update &&. isFunction (opts.update)) {
					opts._update_ = opts.update;
					excluir opts.update;
				} Else {opts._update_ = false;}
				opts.start = function (ev, ui) {
					. $ (Ui.item) css ("border-width", "0px");
					$ ("Td", ui.item). Cada (function (i) {
						. this.style.width = $ t.grid.cols [i] style.width;
					});
					if ($ tpsubGrid) {
						. var subgid = $ (ui.item) attr ("id");
						try {
							. $ ($ T) jqGrid ('collapseSubGridRow', subgid);
						} Catch (e) {}
					}
					if (opts._start_) {
						opts._start_.apply (this, [ev, ui]);
					}
				};
				opts.update = function (ev, ui) {
					. $ (Ui.item) css ("border-width", "");
					if ($ tprownumbers === true) {
						$ ("Td.jqgrid-rownum", $ t.rows). Cada (function (i) {
							. $ (This) html (i +1 + (parseInt ($ tppage, 10) -1) * parseInt ($ tprowNum, 10));
						});
					}
					if (opts._update_) {
						opts._update_.apply (this, [ev, ui]);
					}
				};
				$ ("Tbody: primeiro", $ t) classificáveis ​​(opta);.
				. $ ("Tbody: primeiro", $ t) disableSelection ();
			}
		});
	},
	gridDnD: function () {opta
		voltar this.each (function () {
		var $ t = isso, i, cn;
		if ($ t.grid!) {return;}
		/ / Atualmente desativar um arrastar e soltar TreeGrid
		if ($ tptreeGrid) {return;}
		se | {return;} ($ fn.draggable | fn.droppable $!.!).
		updateDnD função ()
		{
			. var datadnd = $ dados ($ t ", dnd");
			$. ("Tr.jqgrow:. Não (ui-draggable)", $ t) arrastável (. $ IsFunction (datadnd.drag) datadnd.drag.call ($ ($ t), datadnd): datadnd.drag) ;
		}
		var appender = "<table id='jqgrid_dnd' class='ui-jqgrid-dnd'> </ table>";
		if ($ ("# jqgrid_dnd") [0] === indefinido) {
			. $ ('Body') append (appender);
		}

		if (typeof opta === 'string' && opta === 'updateDnD' && $ tpjqgdnd === true) {
			updateDnD ();
			retorno;
		}
		opta = $. estender ({
			"arrastar": function () {opta
				return $. estender ({
					start: function (ev, ui) {
						var i, subgid;
						/ / Se estamos em modo subgrid tentar recolher o nó
						if ($ tpsubGrid) {
							. subgid = $ (ui.helper) attr ("id");
							try {
								. $ ($ T) jqGrid ('collapseSubGridRow', subgid);
							} Catch (e) {}
						}
						/ / Corte
						/ / Arrastar e soltar não insere tr na tabela, quando a tabela não tem linhas
						/ / Tentamos inserir nova linha vazia no alvo (s)
						for (i = 0; i <$ data ($ t ", dnd") connectWith.length;.. i + +) {
							if ($ ($. dados ($ t ", dnd"). connectWith [i]). jqGrid ('getGridParam', 'reccount') === 0) {
								$ (.. $ Data ($ t ", dnd") connectWith [i]) jqGrid ('addRowData', 'jqg_empty_row', {}).;
							}
						}
						ui.helper.addClass ("ui-state-destaque");
						$ ("Td", ui.helper). Cada (function (i) {
							. this.style.width = $ t.grid.headers [i] largura + "px";
						});
						if (opts.onstart && $ isFunction (opts.onstart).) {opts.onstart.call ($ ($ t), ev, ui);}
					},
					parar: function (ev, ui) {
						var i, ids;
						if (ui.helper.dropped &&! opts.dragcopy) {
							. ids = $ (ui.helper) attr ("id");
							if (ids === indefinido) {ids = $ (this) attr ("id");.}
							$ ($ T) jqGrid ('delRowData', ids).;
						}
						/ / Se nós temos uma linha vazia inserido a partir de evento de início tentar excluí-lo
						for (i = 0; i <$ data ($ t ", dnd") connectWith.length;.. i + +) {
							$ JqGrid ('delRowData', 'jqg_empty_row') ($ data ($ t ", dnd") connectWith [i]..).;
						}
						if (opts.onstop && $ isFunction (opts.onstop).) {opts.onstop.call ($ ($ t), ev, ui);}
					}
				}, Opts.drag_opts | | {});
			},
			"Drop": function (opta) {
				return $. estender ({
					aceitar: function (d) {
						if ($ (d) hasClass ('jqgrow')!). {return d;}
						. var tid = $ (d) mais próximo ("table.ui-jqgrid-btable");
						if (tid.length> 0 && $. dados (tid [0], "dnd")! == indefinidos) {
							.. var cn = $ dados (tid [0], "dnd") connectWith;
							return $. inArray ('#' + $. jgrid.jqID (this.id), cn)! == -1? verdadeiro: false;
						}
						return false;
					},
					cair: function (ev, ui) {
						if ($ (ui.draggable) hasClass ('jqgrow')!.) {return;}
						var aceitar = $ (ui.draggable) attr ("id").;
						.. var getdata = ui.draggable.parent () pai () jqGrid ('GetRowData', aceitar);
						if (opts.dropbyname!) {
							var j = 0, tmpdata = {}, nm, chave;
							var dropmodel = $ (". #" + $ jgrid.jqID (this.id)) jqGrid ('getGridParam', 'colModel').;
							try {
								for (chave na getdata) {
									if (getdata.hasOwnProperty (chave)) {
									. nm = dropmodel [j] nome;
									if ((nm === 'cb' | | nm === 'rn' | | nm === 'subgrid')) {
										if (getdata.hasOwnProperty (key) && dropmodel [j]) {
											tmpdata [nm] = getdata [key];
										}
									}
									j + +;
								}
								}
								getdata = tmpdata;
							} Catch (e) {}
						}
						ui.helper.dropped = true;
						if ($ opts.beforedrop &&. isFunction (opts.beforedrop)) {
							/ / parâmetros para esse retorno de chamada - evento, elemento, os dados a serem inseridos, remetente, receptor
							/ / Deve retornar objecto que vai ser inserido no receptor
							var datatoinsert = opts.beforedrop.call (isso, ev, ui, getdata, $ ("#" + $ jgrid.jqID ($ TPID)), este $ ().);
							if (datatoinsert == indefinido && datatoinsert == null && typeof datatoinsert === "objeto"!) {getdata = datatoinsert;}
						}
						if (ui.helper.dropped) {
							grade var;
							if (opts.autoid) {
								if ($. isFunction (opts.autoid)) {
									grade = opts.autoid.call (este, getdata);
								} Else {
									grade = Math.ceil (Math.random () * 1000);
									grade = opts.autoidprefix + grade;
								}
							}
							/ / NULL é interpretado como indefinido enquanto nulo como objeto
							$ JqGrid ('addRowData', grade, getdata, opts.droppos) ("#" + $ jgrid.jqID (this.id).).;
						}
						if (opts.ondrop && $ isFunction (opts.ondrop).) {opts.ondrop.call (isso, ev, ui, getdata);}
					}}, Opts.drop_opts | | {});
			},
			"Onstart": null,
			"OnStop": null,
			"Beforedrop": null,
			"Ondrop": null,
			"drop_opts": {
				"ActiveClass": "ui-state-ativo",
				"HoverClass": "ui-state-pairar"
			},
			"drag_opts": {
				"Reverter": "inválido",
				"Ajudante": "clone",
				"Cursor": "mover-se",
				"AppendTo": "# jqgrid_dnd",
				"ZIndex": 5000
			},
			"Dragcopy": false,
			"Dropbyname": false,
			"droppos": "em primeiro lugar",
			"AutoID": true,
			"Autoidprefix": "dnd_"
		}, Opta | | {});
		
		Se {return;} (opts.connectWith!)
		opts.connectWith = opts.connectWith.split (",");
		. opts.connectWith = $ mapa (opts.connectWith, function (n) {. return $ trim (n);});
		. $ Data ($ t ", dnd", opta);
		
		if ($ tpreccount! == 0 &&! $ tpjqgdnd) {
			updateDnD ();
		}
		$ Tpjqgdnd = true;
		for (i = 0; i <opts.connectWith.length; i + +) {
			cn = opts.connectWith [i];
			. $ (Cn) droppable (.? $ IsFunction (opts.drop) opts.drop.call ($ ($ t), opta): opts.drop);
		}
		});
	},
	gridResize: function () {opta
		voltar this.each (function () {
			var $ t = isso, gid = $ jgrid.jqID ($ TPID).;
			if ($ t.grid | | $ fn.resizable!.) {return;}
			. opta = $ estender ({}, opta | | {});
			if (opts.alsoResize) {
				opts._alsoResize_ = opts.alsoResize;
				excluir opts.alsoResize;
			} Else {
				opts._alsoResize_ = false;
			}
			if ($ opts.stop &&. isFunction (opts.stop)) {
				opts._stop_ = opts.stop;
				excluir opts.stop;
			} Else {
				opts._stop_ = false;
			}
			opts.stop = function (ev, ui) {
				. $ ($ T) jqGrid ('setGridParam', {height:. $ ("# Gview_" + GID + ". Ui-jqgrid-bdiv") Altura ()});
				. $ ($ T) jqGrid ('setGridWidth', ui.size.width, opts.shrinkToFit);
				if (opts._stop_) {opts._stop_.call ($ t, ev, ui);}
			};
			if (opts._alsoResize_) {
				var optstest = "{\ '# gview_" + GID + ". ui-jqgrid-bdiv \': true, '" + opts._alsoResize_ + "': true}";
				opts.alsoResize = eval ('(' + optstest + ')') / / a única maneira que eu encontrei para fazer isso
			} Else {
				opts.alsoResize = $ (". ui-jqgrid-bdiv", "# gview_" + GID);
			}
			excluir opts._alsoResize_;
			$ ("# Gbox_" + GID) redimensionáveis ​​(opta).;
		});
	}
});
}) (JQuery);
/ *
 Transformar uma tabela para um jqGrid.
 Peter Romianowski <peter.romianowski@optivo.de> 
 Se a primeira coluna da tabela contém caixas de seleção ou
 radiobuttons então o jqGrid é feita seleccionável.
* /
/ / Adição - seletor pode ser uma classe ou id
função tableToGrid (seletor, options) {
jQuery (selector) cada (função. () {
	if (this.grid) {return;} / / Adedd de Tony Tomov
	/ / Este é um pequeno "hack" para fazer a largura do jqGrid 100%
	jQuery (this) largura ("99%").;
	var w = jQuery (this) largura ().;

	/ / Texto se temos única ou múltipla escolha
	var inputCheckbox = jQuery ('tr td: entrada do primeiro filho [type = checkbox]: first', jQuery (this));
	var inputRadio = jQuery ('tr td: first-child input [type = rádio]: first', jQuery (this));
	var selectMultiple inputCheckbox.length => 0;
	var selectSingle = selectMultiple && inputRadio.length> 0!;
	var selecionável = selectMultiple | | selectSingle;
	/ / Var inputName = inputCheckbox.attr ("nome") | | inputRadio.attr ("nome");

	/ / Construir o columnModel e os dados
	var colModel = [];
	COLNAMES var = [];
	jQuery ('th', jQuery (this)). cada (function () {
		if (colModel.length === 0 && selecionável) {
			colModel.push ({
				name: '__selection__',
				índice: '__selection__',
				largura: 0,
				escondido: true
			});
			colNames.push ('__selection__');
		} Else {
			colModel.push ({
				name:.. | '. juntar jQuery (this) attr ("id") | jQuery.trim (. jQuery.jgrid.stripHtml (jQuery (this) html ())) split (') ('_'),
				índice:.. jQuery (this) attr ("id") | | jQuery.trim (. jQuery.jgrid.stripHtml (jQuery (this) html ())) split (''). join ('_'),
				width:. jQuery (this) largura () | | 150
			});
			colNames.push (jQuery (this) html ().);
		}
	});
	var data = [];
	rowids var = [];
	var rowChecked = [];
	jQuery ("tbody> tr ', jQuery (this)). cada (function () {
		var row = {};
		var rowPos = 0;
		jQuery ('td', jQuery (this)). cada (function () {
			if (rowPos === 0 && selecionável) {
				entrada var = jQuery ('input', jQuery (this));
				var rowid = input.attr ("value");
				rowIds.push (ROWID | | data.length);
				if (input.is (": checked")) {
					rowChecked.push (ROWID);
				}
				row [. colModel [rowPos] name] = input.attr ("value");
			} Else {
				row [colModel [rowPos] nome.] = jQuery (this) html ().;
			}
			rowPos + +;
		});
		if (rowPos> 0) {data.push (linha);}
	});

	/ / Limpar a tabela HTML original
	jQuery (this) empty ().;

	/ / Mark-lo como jqGrid
	jQuery (this) addClass ("scroll").;

	jQuery (this). jqGrid (jQuery.extend ({
		datatype: "local",
		width: w,
		COLNAMES: COLNAMES,
		colModel: colModel,
		multiselect: selectMultiple
		/ / InputName: inputName,
		/ / InputValueCol: imputName = null? "__selection__": Null
	}, Opções | | {}));

	/ / Adiciona dados
	var um;
	para (a = 0, um <data.length, um + +) {
		var id = null;
		if (rowIds.length> 0) {
			ID = rowIds [a];
			if (ID && id.replace) {
				/ / Nós temos que fazer isso uma vez que o valor de uma caixa de seleção
				/ Botão / ou pode ser qualquer coisa 
				. id = encodeURIComponent (id) replace (/ - / g, "_" [\%.]);
			}
		}
		if (id === null) {
			id = a + 1;
		}
		. jQuery (this) jqGrid ("addRowData", id, data [a]);
	}

	/ / Definir a seleção
	para (a = 0, um <rowChecked.length, um + +) {
		. jQuery (this) jqGrid ("setSelection", rowChecked [a]);
	}
});
};