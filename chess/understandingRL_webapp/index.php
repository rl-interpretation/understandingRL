<html>
<head>
    <title>Chess Tactics with Saliency</title>
    <link rel="stylesheet" href="css/chessboard-1.0.0.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/chessboard-1.0.0.min.js"></script>
    <script src="js/chess.js"></script>
    <script src="js/chess.min.js"></script>
</head>

<body>
    <div id="myBoard" style="width: 400px"></div>
	<script type="text/javascript">
        
	var board = null
	var game = new Chess()
	var $status = $('#status')
	var $fen = $('#fen')
	var $pgn = $('#pgn')

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

	  // illegal move
	  if (move === null) return 'snapback'

	  updateStatus()
	}

	// update the board position after the piece snap
	// for castling, en passant, pawn promotion
	function onSnapEnd () {
	  board.position(game.fen())
	}

	function updateStatus () {
	  var status = ''

	  var moveColor = 'White'
	  if (game.turn() === 'b') {
	    moveColor = 'Black'
	  }

	  // checkmate?
	  if (game.in_checkmate()) {
	    status = 'Game over, ' + moveColor + ' is in checkmate.'
	  }

	  // draw?
	  else if (game.in_draw()) {
	    status = 'Game over, drawn position'
	  }

	  // game still on
	  else {
	    status = moveColor + ' to move'

	    // check?
	    if (game.in_check()) {
	      status += ', ' + moveColor + ' is in check'
	    }
	  }

	  $status.html(status)
	  $fen.html(game.fen())
	  $pgn.html(game.pgn())
	}

	var config = {
	  draggable: true,
	  position: 'start',
	  onDragStart: onDragStart,
	  onDrop: onDrop,
	  onSnapEnd: onSnapEnd
	}
	board = Chessboard('myBoard', config)

	updateStatus()
    </script>
</body>
</html>