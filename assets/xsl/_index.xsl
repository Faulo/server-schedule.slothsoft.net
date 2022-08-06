<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:sfs="http://schema.slothsoft.net/farah/sitemap"
	xmlns:sfm="http://schema.slothsoft.net/farah/module"
	xmlns:ssv="http://schema.slothsoft.net/schema/versioning"
	xmlns:php="http://php.net/xsl" extension-element-prefixes="php">

	<xsl:template match="/*">
		<xsl:variable name="user" select="//user" />
		<html>
			<head>
				<title data-dict="">website/title</title>
				<meta name="viewport"
					content="width=device-width, initial-scale=1" />
				<meta name="author" content="footer/company"
					data-dict="@content" />
				<link rel="icon" type="image/x-icon" href="/favicon.ico" />
			</head>
			<body>
				<header>
					<form class="table" action="/" method="GET"
						onsubmit="querySelector('button').textContent = '…'">
						<div class="button-container">
							<xsl:if test="$user">
								<a class="button" href="/" data-dict="">emoji/back</a>
							</xsl:if>
						</div>
						<div>
							<input type="email" name="user" value="{$user/@email}"
								placeholder="form/placeholder" data-dict="@placeholder"
								required="required" />
						</div>
						<div class="button-container">
							<button type="submit" data-dict="">
								<xsl:choose>
									<xsl:when test="$user/shift">
										<xsl:text>emoji/reload</xsl:text>
									</xsl:when>
									<xsl:otherwise>
										<xsl:text>emoji/submit</xsl:text>
									</xsl:otherwise>
								</xsl:choose>
							</button>
						</div>
					</form>
				</header>

				<main>
					<xsl:apply-templates select="*[@name='user']" />
					<section>
						<h2>
							More infos are available on the
							<a
								href="https://docs.google.com/document/d/1loTufRjf9l4IlaetW06qYlQGp1KZwj29kkfcdYDGQU0/view"
								target="_blank" rel="external">Volunteer Cheat Sheet</a>
						</h2>
						<img
							src="/slothsoft@schedule.slothsoft.net/images/Koelnmesse_plan_devcom_v2_02.png"
							alt="Koelnmesse_plan_devcom_v2_02" />
					</section>
				</main>

				<footer data-dict="">footer</footer>
			</body>
		</html>
	</xsl:template>

	<xsl:template match="*[@name='user'][user/@name]/user">
		<h1>
			<xsl:value-of select="@name" />
		</h1>
		<section>
			<h2 data-dict="">category/shifts</h2>
			<xsl:apply-templates select="shift" />
		</section>
		<section>
			<h2 data-dict="">category/qr</h2>
			<img class="qr"
				src="{php:function('Slothsoft\Server\Schedule\ServerConfig::printQR', string(@email))}"
				alt="{@email}" />
		</section>
	</xsl:template>

	<xsl:template
		match="*[@name='user'][not(user/@name)]/user">
		<section>
			<h2>
				<span data-dict=".">category/notfound/1</span>
				<q class="volunteer-email">
					<xsl:value-of select="@email" />
				</q>
				<span data-dict=".">category/notfound/2</span>
			</h2>
		</section>
	</xsl:template>

	<xsl:template match="*[@name='user'][not(user)]">
		<section>
			<h2 data-dict="">category/home</h2>
		</section>
	</xsl:template>

	<xsl:template match="shift">
		<article class="shift">
			<xsl:if test="@checked-in">
				<xsl:attribute name="data-checked-in" />
			</xsl:if>
			<h3>
				<xsl:value-of select="@name" />
			</h3>
			<table data-dict=".//html:td[1]/node()">
				<tr>
					<td>emoji/date</td>
					<td>
						<xsl:value-of select="@date-buffered" />
					</td>
				</tr>
				<tr>
					<td>emoji/time</td>
					<td>
						<xsl:value-of select="@start-buffered" />
						<xsl:text> - </xsl:text>
						<xsl:value-of select="@end" />
					</td>
				</tr>
				<tr>
					<td>emoji/location</td>
					<td>
						<xsl:value-of select="@location" />
					</td>
				</tr>
				<xsl:if test="@note">
					<tr>
						<td>emoji/info</td>
						<td>
							<q>
								<xsl:value-of select="@note" />
							</q>
						</td>
					</tr>
				</xsl:if>
			</table>
		</article>
	</xsl:template>
</xsl:stylesheet>