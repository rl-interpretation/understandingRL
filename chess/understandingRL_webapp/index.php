<?php 
	require_once 'dbconnect.php';
?>
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
	<div style="width: 1000px">
	    <div id="myBoard" style="width: 400px; float: left;"></div>
	    <div id='map' style="width: 400px; float: right;"></div>
    </div>
    <!-- <input type="button" id="startPositionBtn5" value="|<" />
	<input type="button" id="prevBtn5" value="<" />
	<input type="button" id="nextBtn5" value=">" />
	<input type="button" id="endPositionBtn5" value=">|" />
	 --><p id="pgn5"></p>
	</div>
	<script type="text/javascript">
		$(function() {
			// const fs = require('fs')
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
				// illegal move
				if (move === null) return 'snapback'
				
				if(source != history[i].from || target != history[i].to){
					alert('Wrong move played. You played: ' + source + target + '. Required move: ' + history[i].from + history[i].to);
					
				    var form = document.createElement("form");
				    var element1 = document.createElement("input"); 
				    var element2 = document.createElement("input");  
				    var element3 = document.createElement("input");  
				    var element4 = document.createElement("input");  

				    form.method = "POST";
				    form.action = "submit.php";   

				    element1.value=idx;
				    element1.name="idx";
				    form.appendChild(element1);  

				    element2.value=show_saliency;
				    element2.name="sal";
				    form.appendChild(element2);

				    element3.value=0;
				    element3.name="solve";
				    form.appendChild(element3);

				    element4.value=-1;
				    element4.name="time_t";
				    form.appendChild(element4);

				    document.body.appendChild(form);

				    form.submit();
					
					return 'snapback'
				}
				i+=1
				if(i >= history.length) {
					var endDate = new Date();
					var end = endDate.getTime()
					var time = (end - start)/1000.0						
					var form = document.createElement("form");
				    var element1 = document.createElement("input"); 
				    var element2 = document.createElement("input");  
				    var element3 = document.createElement("input");  
				    var element4 = document.createElement("input");  

				    form.method = "POST";
				    form.action = "submit.php";   

				    element1.value=idx;
				    element1.name="idx";
				    form.appendChild(element1);  

				    element2.value=show_saliency;
				    element2.name="sal";
				    form.appendChild(element2);

				    element3.value=1;
				    element3.name="solve";
				    form.appendChild(element3);

				    element4.value=time;
				    element4.name="time_t";
				    form.appendChild(element4);

				    document.body.appendChild(form);

					alert('Good going. Time taken: ' + time)
				    form.submit();
					
					return true
					
				}
				else {
					game.move(history[i].san)
					i+=1	
				}
			}
			// update the board position after the piece snap
			// for castling, en passant, pawn promotion
			function onSnapEnd () {
				board.position(game.fen())
			}
			var show_saliency = (Math.random() > 0.5)
			if(show_saliency){
				alert("Play the tactic for white on the board on the left. You can take help from the board on the right which highlights important pieces for the tactic. Time will start when you click on OK.");
			}
			else {
				alert("Play the tactic for white on the board on the left. Time will start when you click on OK.")
			}

			var pgn = ['[Event "Tactic"]',
			'[Site "Earth"]',
			'[Date "2019.??.??"]',
			'[EventDate "?"]',
			'[Round "?"]',
			'[Result "0-0"]',
			'[White "You"]',
			'[Black "Opponent"]',
			'[FEN "2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1"]',
			'[SetUp "1"]',
			'',
			'1. g4 Qf6 2. Bg5 Qxg5 3. Qxg5'];
		
			var list_of_fens = [];
			var list_of_pgns = [];

			list_of_fens.push('2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1');
			list_of_fens.push('rnbq1rk1/pp2bppp/4p3/3p3n/3P1B2/3B1N2/PPPNQPPP/R3K2R w KQkq - 0 1');
			list_of_fens.push('rnbqk1nr/1p3ppp/4p3/2bp4/8/p3PN2/1BP2PPP/RN1QKB1R w - - 0 1');
			list_of_fens.push('1k3r2/p6p/2p1Bp2/4p3/1b1pP3/3P2P1/P1K4P/5R2 w - - 0 1');
			list_of_fens.push('rn1qk1nr/p1pp1ppp/1pb1p3/8/2BQ4/2P2N2/PPP2PPP/R1B2RK1 w - - 0 1');
			list_of_fens.push('r1r5/2k3pp/2p2p2/1pR1pq2/PQ1n4/3P4/1P4PP/1KRB4 w - - 0 1');
			list_of_fens.push('r2r4/1kp2p1p/1q2b1p1/R7/Q7/P1N5/1PP4P/1K5R w - - 0 1');
			list_of_fens.push('4r1k1/1R4p1/4qp1p/8/3r4/1Q3R1P/6P1/7K w - - 0 1');
			list_of_fens.push('2kr3r/bbqp1pp1/p3p3/1p2n3/1P1NPBnp/P2B2QP/2P1NPP1/R1R3K1 w - - 0 1');
			list_of_fens.push('1r6/pkp2p1p/5b2/5p2/5P2/q1PP4/2R1N2P/1K4Q1 w - - 0 1');
			list_of_fens.push('1kr5/pr4p1/5n1p/5p2/3P4/qbR2P1P/B2Q1NP1/K6R w - - 0 1');
			list_of_fens.push('1kr2b1r/1pq2bpp/p3np2/2p1p3/4P3/2N1BPN1/PPPR1QPP/1K1R4 w - - 0 1');
			list_of_fens.push('5rk1/p1q2ppp/1p2p1n1/2p1r2Q/2P5/3B4/PP3PPP/3RR1K1 w - - 0 1');
			list_of_fens.push('4rrk1/pp1qp1bp/2pnbpp1/8/3PNP2/2PB4/PP2Q1PP/R1B2RK1 w - - 0 1');
			list_of_fens.push('2b1r1k1/2q1bppp/2p3n1/r1B1p3/N3n3/5N2/P3BPPP/2RQ1RK1 w - - 0 1');


			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "2r1r1k1/b4ppp/p3p3/Pp2Nq2/1Pbp1B2/R7/2PQ1PP1/4R1K1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. g4 Qf6 2. Bg5 Qxe5 3. Rxe5'];

			list_of_pgns.push(pgn);	

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "rnbq1rk1/pp2bppp/4p3/3p3n/3P1B2/3B1N2/PPPNQPPP/R3K2R w KQkq - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Bxb8 Rxb8 2. Qe5 Nf4 3. Qxf4'];


			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "rnbqk1nr/1p3ppp/4p3/2bp4/8/p3PN2/1BP2PPP/RN1QKB1R w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Bxg7 a2 2. Nbd2 Nf6 3. Bxh8'];


			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "1k3r2/p6p/2p1Bp2/4p3/1b1pP3/3P2P1/P1K4P/5R2 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Rb1 a5 2. a3 Kc7 3. axb4'];

			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "rn1qk1nr/p1pp1ppp/1pb1p3/8/2BQ4/2P2N2/PPP2PPP/R1B2RK1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Qxg7 Qf6 2. Bh6 Qxh6 3. Qxh8'];


			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "r1r5/2k3pp/2p2p2/1pR1pq2/PQ1n4/3P4/1P4PP/1KRB4 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Qxd4 exd4 2. Rxf5'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "r2r4/1kp2p1p/1q2b1p1/R7/Q7/P1N5/1PP4P/1K5R w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Qe4+ c6 2. Rb5 Qxb5 3. Nxb5'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "4r1k1/1R4p1/4qp1p/8/3r4/1Q3R1P/6P1/7K w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Re3 Qxb3 2. Rxe8+ Kh7 3. Rxb3'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "2kr3r/bbqp1pp1/p3p3/1p2n3/1P1NPBnp/P2B2QP/2P1NPP1/R1R3K1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Qxg4 Nxg4 2. Bxc7 Kxc7 3. hxg4'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "1r6/pkp2p1p/5b2/5p2/5P2/q1PP4/2R1N2P/1K4Q1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Rb2+ Kc8 2. Qg8+ Bd8 3. Rxb8+ Kxb8 4. Qxd8+'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "1kr5/pr4p1/5n1p/5p2/3P4/qbR2P1P/B2Q1NP1/K6R w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Qf4+ Rcc7 2. Qxc7+ Rxc7 3. Rxb3+ Qxb3 4. Bxb3'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "1kr2b1r/1pq2bpp/p3np2/2p1p3/4P3/2N1BPN1/PPPR1QPP/1K1R4 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Rd7 Qc6 2. Rxf7'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "5rk1/p1q2ppp/1p2p1n1/2p1r2Q/2P5/3B4/PP3PPP/3RR1K1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Rxe5 Qxe5 2. Bxg6 Qxh5 3. Bxh5'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "4rrk1/pp1qp1bp/2pnbpp1/8/3PNP2/2PB4/PP2Q1PP/R1B2RK1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Nc5 Bg4 2. Nxd7 Bxe2 3. Bxe2'];
			list_of_pgns.push(pgn);

			pgn = ['[Event "Tactic"]',
				'[Site "Earth"]',
				'[Date "2019.??.??"]',
				'[EventDate "?"]',
				'[Round "?"]',
				'[Result "0-0"]',
				'[White "You"]',
				'[Black "Opponent"]',
				'[FEN "2b1r1k1/2q1bppp/2p3n1/r1B1p3/N3n3/5N2/P3BPPP/2RQ1RK1 w - - 0 1"]',
				'[SetUp "1"]',
				'',
				'1. Bb6 Qb7 2. Bxa5'];
			list_of_pgns.push(pgn);


			var idx = Math.floor(Math.random() * 15);

			if(show_saliency) {
				document.getElementById('map').innerHTML = '<img src="maps/' + idx + '.png">'
			}

			console.log(idx)
			var board = null
			var config = {
				position: list_of_fens[idx],
				draggable: true,
				onDragStart: onDragStart,
				onDrop: onDrop,
				onSnapEnd: onSnapEnd
			}
			var game = new Chess();
			board = ChessBoard('myBoard', config);
			
			// 1. Load a PGN into the game
			pgn = list_of_pgns[idx];
			game.load_pgn(list_of_pgns[idx].join('\n'));

			
			// 2. Get the full move history
			var history = game.history({verbose: true});
			game.load(list_of_fens[idx]);
			var i = 0;
			var d = new Date();
			var start = d.getTime();
			// 3. If Next button clicked, move forward one
			// $('#nextBtn5').on('click', function() {
			// 	game.move(history[i].san);
			// 	board.position(game.fen());
			// 	i += 1;
			// 	if (i > history.length) {
			// 	  i = history.length;
			// 	}
			// });			
			// // 4. If Prev button clicked, move backward one
			// $('#prevBtn5').on('click', function() {
			// 	game.undo();
			// 	board.position(game.fen());
			// 	i -= 1;
			// 	if (i < 0) {
			// 		i = 0;
			// 	}
			// });
			// // 5. If Start button clicked, go to start position
			// $('#startPositionBtn5').on('click', function() {
			// 	game.load(list_of_fens[idx]);
			// 	board.start();
			// 	i = 0;
			// });
			// // 6. If End button clicked, go to end position
			// $('#endPositionBtn5').on('click', function() {
			// 	game.load_pgn(pgn);
			// 	board.position(game.fen());
			// 	i = history.length;
			// });
			




		});
	</script>
</body>
</html>