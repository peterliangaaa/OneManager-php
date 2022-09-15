<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php if($this->options->favicon): ?><link rel="shortcut icon" href="<?php $this->options->favicon(); ?>"><?php endif;?>
<?php if ($this->options->seotitle && $this->is('index')):?>
<title><?php $this->options->seotitle(); ?></title><?php else : ?><title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
<?php endif; ?>

		
<?php if($this->options->favicon): ?><link rel="shortcut icon" href="<?php $this->options->favicon(); ?>"><?php endif;?>
	
<link href="<?php $this->options->themeUrl('css/app.css'); ?>" rel="stylesheet">
<link href="<?php $this->options->themeUrl('css/font-awesome.min.css'); ?>" rel="stylesheet">
	
<script type="text/javascript" src="<?php $this->options->themeUrl('js/jquery.js'); ?>"></script>		
<script type="text/javascript" src="<?php $this->options->themeUrl('js/MDmain.js'); ?>"></script>
<?php if ($this->options->webcss): ?>
<style type="text/css"><?php $this->options->webcss(); ?></style>
<?php endif; ?>
<?php if ($this->options->tophtml): ?>
<?php $this->options->tophtml(); ?>
<?php endif; ?> 
<!-- 通过自有函数输出HTML头部信息 -->
<?php $this->header(); ?>
	</head>
	<body>
	<?php $this->need('lib/nav.php'); ?>		