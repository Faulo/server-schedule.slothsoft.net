<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:sfs="http://schema.slothsoft.net/farah/sitemap"
	xmlns:sfm="http://schema.slothsoft.net/farah/module"
	xmlns:ssv="http://schema.slothsoft.net/schema/versioning">

	<xsl:template match="/*">
		<html>
			<head>
				<title data-dict="">website/title</title>
				<style type="text/css"><![CDATA[
			]]></style>
			</head>
			<body>
				<header>
					<h1 data-dict="">website/title</h1>
				</header>
				<main>
					<xsl:for-each select="*[@name='user']">
						<p>
							Hello,
							<xsl:value-of select="user/@name" />
						</p>
					</xsl:for-each>
				</main>
				<footer>
					<span data-dict=".">footer/copyright</span>
					<span data-dict=".">footer/company</span>
				</footer>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>