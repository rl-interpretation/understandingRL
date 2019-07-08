<html>
<head>
    <title>Chess Tactics with Saliency</title>
    <link rel="stylesheet" href="css/chessboard-1.0.0.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/chessboard-1.0.0.min.js"></script>
    <script src="js/chessboard-1.0.0.js"></script>
    <script src="js/chess.js"></script>
    <script src="js/chess.min.js"></script>
</head>

<body>
    <div id="myBoard" style="width: 400px"></div>
    <input type="button" id="startPositionBtn5" value="|<" />
	<input type="button" id="prevBtn5" value="<" />
	<input type="button" id="nextBtn5" value=">" />
	<input type="button" id="endPositionBtn5" value=">|" />
	<p><span id="pgn5"></span></p>
	</div>
	<script type="text/javascript">
		$(function() {
			function onDragStart (source, piece, position, orientation) {
	  			// do not pick up pieces if the game is over
				if (game.game_over()) return false

				// only pick up pieces for the side to move
				if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
				  (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
				return false
				}
			}

			function onDrop (source, target) {
				// see if the move is legal
				var move = game.move({
					from: source,
					to: target,
					promotion: 'q' // NOTE: always promote to a queen for example simplicity
				})
				if (source == target) return 'snapback'
				if(source != history[i].from || target != history[i].to){
					alert(source + target + ' ' + history[i].san + 'Wrong move played')
					exit()
					return 'snapback'
				}

				// illegal move
				if (move === null) return 'snapback'
				i+=1
				if(i >= history.length) {
					var endDate = new Date();
					var end = endDate.getTime()
					var time = (end - start)/1000.0
					alert('Good going. Time taken: ' + time)
					return true
					exit()
				}
				else {
					game.move(history[i].san)
					i+=1	
				}
				// updateStatus()
			}

				// update the board position after the piece snap
				// for castling, en passant, pawn promotion
			function onSnapEnd () {
				board.position(game.fen())
			}

			var board = null
			var config = {
				position: '2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1',
				draggable: true,
				onDragStart: onDragStart,
				onDrop: onDrop,
				onSnapEnd: onSnapEnd
			// position: 'start'
			}
			var game = new Chess();
			board = ChessBoard('myBoard', config);

			// 1. Load a PGN into the game
			var pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "Lab Rat"]',
				'[Black "Opponent"]',
				'[FEN "2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. g4 Qf6 2. Bg5 Qxg5 3. Qxg5'];
			game.load_pgn(pgn.join('\n'));

			$('#pgn5').html(pgn);
			
			// 2. Get the full move history
			var history = game.history({verbose: true});
			game.load('2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1');
			var i = 0;

			var d = new Date();
			var start = d.getTime();

			// 3. If Next button clicked, move forward one
			$('#nextBtn5').on('click', function() {
				game.move(history[i].san);
				board.position(game.fen());
				i += 1;
				if (i > history.length) {
				  i = history.length;
				}
			});			
			// 4. If Prev button clicked, move backward one
			$('#prevBtn5').on('click', function() {
				game.undo();
				board.position(game.fen());
				i -= 1;
				if (i < 0) {
					i = 0;
				}
			});
			// 5. If Start button clicked, go to start position
			$('#startPositionBtn5').on('click', function() {
				game.load('2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1');
				board.start();
				i = 0;
			});

			// 6. If End button clicked, go to end position
			$('#endPositionBtn5').on('click', function() {
				game.load_pgn(pgn);
				board.position(game.fen());
				i = history.length;
			});

			

		});
	</script>
	<div id='tt'></div>
</body>
</html>