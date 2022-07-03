<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:sfs="http://schema.slothsoft.net/farah/sitemap"
	xmlns:sfm="http://schema.slothsoft.net/farah/module"
	xmlns:ssv="http://schema.slothsoft.net/schema/versioning">

	<xsl:template match="/*">
		<xsl:variable name="user" select="//user" />
		<html>
			<head>
				<title data-dict="">website/title</title>
				<meta name="viewport"
					content="width=device-width, initial-scale=1" />
				<meta name="author" content="footer/company"
					data-dict="@content" />
				<style type="text/css"><![CDATA[
			]]></style>
			</head>
			<body>
				<header>
					<h1 data-dict="">website/title</h1>
				</header>
				<nav>
					<form action="/" method="GET">
						<input type="text" name="user" value="{$user/@email}"
							placeholder="yourname@email.com" />
						<xsl:text> </xsl:text>
						<button type="submit">Retrieve Schedule</button>
					</form>
				</nav>
				<main>
					<xsl:apply-templates select="*[@name='user']" />
				</main>
				<footer>
					<span data-dict=".">footer/copyright</span>
					<span data-dict=".">footer/company</span>
				</footer>
			</body>
		</html>
	</xsl:template>

	<xsl:template match="*[@name='user'][user/@name]/user">
		<p>
			This is the schedule for:
			<span class="volunteer-name">
				<xsl:value-of select="@name" />
			</span>
		</p>
		<xsl:apply-templates select="shift" />
	</xsl:template>

	<xsl:template
		match="*[@name='user'][not(user/@name)]/user">
		<p>
			Sorry, we don't have any shifts for:
			<span class="volunteer-email">
				<xsl:value-of select="@email" />
			</span>
		</p>
	</xsl:template>

	<xsl:template match="*[@name='user'][not(user)]">
		<p>
			Enter your email address to display your schedule!
		</p>
	</xsl:template>

	<xsl:template match="shift">
		<article class="shift">
			<p class="shift-time">
				<xsl:value-of select="@start-buffered" />
				-
				<xsl:value-of select="@end" />
			</p>
			<h2 class="shift-name">
				<xsl:value-of select="@name" />
			</h2>
			<p class="shift-location">
				<xsl:text>📍 </xsl:text>
				<xsl:value-of select="@location" />
			</p>
		</article>
	</xsl:template>
</xsl:stylesheet>