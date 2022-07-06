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
				<style type="text/css"><![CDATA[
			]]></style>
			</head>
			<body>

				<table>
					<thead>
					   <xsl:choose>
					       <xsl:when test="$user/shift">
						        <tr class="header">
						            <td><a class="button" href="/">⇠</a></td>
						            <th><xsl:value-of select="$user/@name" /></th>
						            <td><a class="button" href="/?user={php:function('urlencode', string($user/@email))}">↻<xsl:copy-of select="."/></a></td>
						        </tr>
					       </xsl:when>
					       <xsl:otherwise>
		                        <tr class="header">
		                            <th colspan="2" class="p" data-dict="">website/title</th>
		                        </tr>
					       </xsl:otherwise>
					   </xsl:choose>
					</thead>
					<tfoot>
						<tr class="footer">
							<th colspan="3" class="p" >
								<span data-dict=".">footer/copyright</span>
								<span data-dict=".">footer/company</span>
							</th>
						</tr>
					</tfoot>
					<tbody>
						<xsl:if test="not($user/shift)">
							<tr>
								<th colspan="3">
									<form action="/" method="GET">
										<input type="text" name="user" value="{$user/@email}"
											placeholder="yourname@email.com" />
                                        <button type="submit">🔍︎</button>
									</form>
								</th>
							</tr>
						</xsl:if>
						<xsl:apply-templates select="*[@name='user']" />
					</tbody>
				</table>
			</body>
		</html>
	</xsl:template>

	<xsl:template match="*[@name='user'][user/@name]/user">
        <tr class="category">
            <th colspan="3" class="p">These are your shifts:</th>
        </tr>
		<xsl:apply-templates select="shift" />
		<tr class="category">
			<th colspan="3" class="p">This is your QR code for checking in:</th>
		</tr>
		<tr>
		  <th colspan="3">		  
	        <img class="qr"
		            src="{php:function('Slothsoft\Server\Schedule\ServerConfig::printQR', string(@email))}"
		            alt="{@email}" />
		  </th>
		</tr>
	</xsl:template>

	<xsl:template
		match="*[@name='user'][not(user/@name)]/user">
        <tr class="category">
            <th colspan="3" class="p">Sorry, we don't have any shifts for:
            <span class="volunteer-email">
                <xsl:value-of select="@email" />
            </span></th>
        </tr>
	</xsl:template>

	<xsl:template match="*[@name='user'][not(user)]">
		<tr class="category">
		  <th colspan="2" class="p">
			Enter your email address to display your schedule!</th>
		</tr>
	</xsl:template>

	<xsl:template match="shift">
	   <tr>
	       <th colspan="3">
		<article class="shift">
			<p>
				<span class="shift-date">
					<xsl:value-of select="@date-buffered" />
				</span>
				<xsl:text> </xsl:text>
				<span class="shift-time">
					<xsl:value-of select="@start-buffered" />
					<xsl:text> - </xsl:text>
					<xsl:value-of select="@end" />
				</span>
			</p>
			<h2 class="shift-name">
				<xsl:value-of select="@name" />
			</h2>
			<p class="shift-location">
				<xsl:text>📍 </xsl:text>
				<xsl:value-of select="@location" />
			</p>
			<xsl:if test="@note">
				<p class="shift-note">
					<xsl:text>🛈 </xsl:text>
					<xsl:value-of select="@note" />
				</p>
			</xsl:if>
			<xsl:if test="@checked-in">
				<p class="shift-checkin">
					<xsl:text>Y You have checked in for this shift!</xsl:text>
				</p>
			</xsl:if>
		</article></th></tr>
	</xsl:template>
</xsl:stylesheet>