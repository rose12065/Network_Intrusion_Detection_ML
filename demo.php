<?php
use Phpml\Tree\Node;
use Phpml\Tree\Tree;

// Assume $decisionTree is your trained decision tree model
$tree = $decisionTree->getTree();
$dotContent = generateDotFile($tree);

function generateDotFile(Tree $tree, $root = true)
{
    $dot = '';

    if ($root) {
        $dot .= "digraph DecisionTree {\n";
        $dot .= "node [shape=box];\n";
    }

    $split = $tree->getSplit();
    $dot .= sprintf(
        'N%d [label="%s <= %s"]' . ($root ? '' : 'N%d') . ";\n",
        $tree->getId(),
        $split->getIndex(),
        $split->getValue(),
        $tree->getId()
    );

    if ($tree->isLeaf()) {
        $dot .= sprintf('N%d [label="Class %s"]' . ";\n", $tree->getId(), $tree->getLeaf());
    } else {
        $dot .= generateDotFile($tree->getLeft(), false);
        $dot .= generateDotFile($tree->getRight(), false);
    }

    if ($root) {
        $dot .= "}\n";
    }

    return $dot;
}

file_put_contents('decision_tree.dot', $dotContent);
?>