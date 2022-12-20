<?php
// This file was auto-generated from sdk-root/src/data/glue/2017-03-31/endpoint-tests-1.json
return [ 'testCases' => [ [ 'documentation' => 'For region ap-south-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-south-1', ], ], [ 'documentation' => 'For region ap-south-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-south-1', ], ], [ 'documentation' => 'For region ap-south-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-south-1', ], ], [ 'documentation' => 'For region ap-south-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-south-1', ], ], [ 'documentation' => 'For region eu-south-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-south-1', ], ], [ 'documentation' => 'For region eu-south-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-south-1', ], ], [ 'documentation' => 'For region eu-south-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-south-1', ], ], [ 'documentation' => 'For region eu-south-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-south-1', ], ], [ 'documentation' => 'For region eu-south-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-south-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-south-2', ], ], [ 'documentation' => 'For region eu-south-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-south-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-south-2', ], ], [ 'documentation' => 'For region eu-south-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-south-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-south-2', ], ], [ 'documentation' => 'For region eu-south-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-south-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-south-2', ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-gov-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-gov-east-1', ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-gov-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-gov-east-1', ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-gov-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-gov-east-1', ], ], [ 'documentation' => 'For region us-gov-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-gov-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-gov-east-1', ], ], [ 'documentation' => 'For region me-central-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.me-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'me-central-1', ], ], [ 'documentation' => 'For region me-central-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.me-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'me-central-1', ], ], [ 'documentation' => 'For region me-central-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.me-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'me-central-1', ], ], [ 'documentation' => 'For region me-central-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.me-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'me-central-1', ], ], [ 'documentation' => 'For region ca-central-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ca-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ca-central-1', ], ], [ 'documentation' => 'For region ca-central-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ca-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ca-central-1', ], ], [ 'documentation' => 'For region ca-central-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ca-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ca-central-1', ], ], [ 'documentation' => 'For region ca-central-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ca-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ca-central-1', ], ], [ 'documentation' => 'For region eu-central-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-central-1', ], ], [ 'documentation' => 'For region eu-central-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-central-1', ], ], [ 'documentation' => 'For region eu-central-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-central-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-central-1', ], ], [ 'documentation' => 'For region eu-central-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-central-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-central-1', ], ], [ 'documentation' => 'For region us-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-west-1', ], ], [ 'documentation' => 'For region us-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-west-1', ], ], [ 'documentation' => 'For region us-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-west-1', ], ], [ 'documentation' => 'For region us-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-west-1', ], ], [ 'documentation' => 'For region us-west-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-west-2', ], ], [ 'documentation' => 'For region us-west-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-west-2', ], ], [ 'documentation' => 'For region us-west-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-west-2', ], ], [ 'documentation' => 'For region us-west-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-west-2', ], ], [ 'documentation' => 'For region af-south-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.af-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'af-south-1', ], ], [ 'documentation' => 'For region af-south-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.af-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'af-south-1', ], ], [ 'documentation' => 'For region af-south-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.af-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'af-south-1', ], ], [ 'documentation' => 'For region af-south-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.af-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'af-south-1', ], ], [ 'documentation' => 'For region eu-north-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-north-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-north-1', ], ], [ 'documentation' => 'For region eu-north-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-north-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-north-1', ], ], [ 'documentation' => 'For region eu-north-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-north-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-north-1', ], ], [ 'documentation' => 'For region eu-north-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-north-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-north-1', ], ], [ 'documentation' => 'For region eu-west-3 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-west-3.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-west-3', ], ], [ 'documentation' => 'For region eu-west-3 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-west-3.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-west-3', ], ], [ 'documentation' => 'For region eu-west-3 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-west-3.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-west-3', ], ], [ 'documentation' => 'For region eu-west-3 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-west-3.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-west-3', ], ], [ 'documentation' => 'For region eu-west-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-west-2', ], ], [ 'documentation' => 'For region eu-west-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-west-2', ], ], [ 'documentation' => 'For region eu-west-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-west-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-west-2', ], ], [ 'documentation' => 'For region eu-west-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-west-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-west-2', ], ], [ 'documentation' => 'For region eu-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'eu-west-1', ], ], [ 'documentation' => 'For region eu-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.eu-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'eu-west-1', ], ], [ 'documentation' => 'For region eu-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'eu-west-1', ], ], [ 'documentation' => 'For region eu-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.eu-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'eu-west-1', ], ], [ 'documentation' => 'For region ap-northeast-3 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-northeast-3.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-northeast-3', ], ], [ 'documentation' => 'For region ap-northeast-3 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-northeast-3.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-northeast-3', ], ], [ 'documentation' => 'For region ap-northeast-3 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-northeast-3.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-northeast-3', ], ], [ 'documentation' => 'For region ap-northeast-3 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-northeast-3.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-northeast-3', ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-northeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-northeast-2', ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-northeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-northeast-2', ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-northeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-northeast-2', ], ], [ 'documentation' => 'For region ap-northeast-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-northeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-northeast-2', ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-northeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-northeast-1', ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-northeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-northeast-1', ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-northeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-northeast-1', ], ], [ 'documentation' => 'For region ap-northeast-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-northeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-northeast-1', ], ], [ 'documentation' => 'For region me-south-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.me-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'me-south-1', ], ], [ 'documentation' => 'For region me-south-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.me-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'me-south-1', ], ], [ 'documentation' => 'For region me-south-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.me-south-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'me-south-1', ], ], [ 'documentation' => 'For region me-south-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.me-south-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'me-south-1', ], ], [ 'documentation' => 'For region sa-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.sa-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'sa-east-1', ], ], [ 'documentation' => 'For region sa-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.sa-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'sa-east-1', ], ], [ 'documentation' => 'For region sa-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.sa-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'sa-east-1', ], ], [ 'documentation' => 'For region sa-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.sa-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'sa-east-1', ], ], [ 'documentation' => 'For region ap-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-east-1', ], ], [ 'documentation' => 'For region ap-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-east-1', ], ], [ 'documentation' => 'For region ap-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-east-1', ], ], [ 'documentation' => 'For region ap-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-east-1', ], ], [ 'documentation' => 'For region cn-north-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.cn-north-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'cn-north-1', ], ], [ 'documentation' => 'For region cn-north-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.cn-north-1.amazonaws.com.cn', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'cn-north-1', ], ], [ 'documentation' => 'For region cn-north-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.cn-north-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'cn-north-1', ], ], [ 'documentation' => 'For region cn-north-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.cn-north-1.amazonaws.com.cn', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'cn-north-1', ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-gov-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-gov-west-1', ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-gov-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-gov-west-1', ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-gov-west-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-gov-west-1', ], ], [ 'documentation' => 'For region us-gov-west-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-gov-west-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-gov-west-1', ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-southeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-southeast-1', ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-southeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-southeast-1', ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-southeast-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-southeast-1', ], ], [ 'documentation' => 'For region ap-southeast-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-southeast-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-southeast-1', ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-southeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-southeast-2', ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-southeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-southeast-2', ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-southeast-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-southeast-2', ], ], [ 'documentation' => 'For region ap-southeast-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-southeast-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-southeast-2', ], ], [ 'documentation' => 'For region us-iso-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'error' => 'FIPS and DualStack are enabled, but this partition does not support one or both', ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-iso-east-1', ], ], [ 'documentation' => 'For region us-iso-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-iso-east-1.c2s.ic.gov', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-iso-east-1', ], ], [ 'documentation' => 'For region us-iso-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'error' => 'DualStack is enabled but this partition does not support DualStack', ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-iso-east-1', ], ], [ 'documentation' => 'For region us-iso-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-iso-east-1.c2s.ic.gov', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-iso-east-1', ], ], [ 'documentation' => 'For region ap-southeast-3 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-southeast-3.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'ap-southeast-3', ], ], [ 'documentation' => 'For region ap-southeast-3 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.ap-southeast-3.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'ap-southeast-3', ], ], [ 'documentation' => 'For region ap-southeast-3 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-southeast-3.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'ap-southeast-3', ], ], [ 'documentation' => 'For region ap-southeast-3 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.ap-southeast-3.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'ap-southeast-3', ], ], [ 'documentation' => 'For region us-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-east-1', ], ], [ 'documentation' => 'For region us-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-east-1', ], ], [ 'documentation' => 'For region us-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-east-1.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-east-1', ], ], [ 'documentation' => 'For region us-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-east-1.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-east-1', ], ], [ 'documentation' => 'For region us-east-2 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-east-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-east-2', ], ], [ 'documentation' => 'For region us-east-2 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-east-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-east-2', ], ], [ 'documentation' => 'For region us-east-2 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-east-2.api.aws', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-east-2', ], ], [ 'documentation' => 'For region us-east-2 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-east-2.amazonaws.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-east-2', ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.cn-northwest-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'cn-northwest-1', ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.cn-northwest-1.amazonaws.com.cn', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'cn-northwest-1', ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.cn-northwest-1.api.amazonwebservices.com.cn', ], ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'cn-northwest-1', ], ], [ 'documentation' => 'For region cn-northwest-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.cn-northwest-1.amazonaws.com.cn', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'cn-northwest-1', ], ], [ 'documentation' => 'For region us-isob-east-1 with FIPS enabled and DualStack enabled', 'expect' => [ 'error' => 'FIPS and DualStack are enabled, but this partition does not support one or both', ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => true, 'Region' => 'us-isob-east-1', ], ], [ 'documentation' => 'For region us-isob-east-1 with FIPS enabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue-fips.us-isob-east-1.sc2s.sgov.gov', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-isob-east-1', ], ], [ 'documentation' => 'For region us-isob-east-1 with FIPS disabled and DualStack enabled', 'expect' => [ 'error' => 'DualStack is enabled but this partition does not support DualStack', ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-isob-east-1', ], ], [ 'documentation' => 'For region us-isob-east-1 with FIPS disabled and DualStack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://glue.us-isob-east-1.sc2s.sgov.gov', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-isob-east-1', ], ], [ 'documentation' => 'For custom endpoint with fips disabled and dualstack disabled', 'expect' => [ 'endpoint' => [ 'url' => 'https://example.com', ], ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => false, 'Region' => 'us-east-1', 'Endpoint' => 'https://example.com', ], ], [ 'documentation' => 'For custom endpoint with fips enabled and dualstack disabled', 'expect' => [ 'error' => 'Invalid Configuration: FIPS and custom endpoint are not supported', ], 'params' => [ 'UseDualStack' => false, 'UseFIPS' => true, 'Region' => 'us-east-1', 'Endpoint' => 'https://example.com', ], ], [ 'documentation' => 'For custom endpoint with fips disabled and dualstack enabled', 'expect' => [ 'error' => 'Invalid Configuration: Dualstack and custom endpoint are not supported', ], 'params' => [ 'UseDualStack' => true, 'UseFIPS' => false, 'Region' => 'us-east-1', 'Endpoint' => 'https://example.com', ], ], ], 'version' => '1.0',];
